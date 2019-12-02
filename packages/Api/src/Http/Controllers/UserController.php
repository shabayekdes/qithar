<?php

namespace Api\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MealResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'current_password' => 'required|integer',
            'new_password' => 'required|min:6'
        ]);
        $credentials = [
            "phone" => $user->phone,
            "password" => $request->current_password
        ];

        if(!Auth::guard('web')->attempt($credentials)){
            return response()->json([
                "message" => "The current password is wrong."
            ], 401);
        }
        $request->merge(['password' => Hash::make($request->new_password)]);

        $user->update($request->all());
        return response()->json([
            'message' => 'Your password was updated!',
            'code' => 200
        ], 200);
    }
    public function update(Request $request)
    {
        $user = auth()->user();

        $user->update($request->all());
        return response()->json([
            'message' => 'Your info was updated!',
            'code' => 200
        ], 200);
    }

    public function myRating()
    {
        $orders = auth()->user()->orders()->with('dinners.meals')->get();

        $dinners = collect();
        foreach ($orders as $order) {
            $dinners->add($order->dinners);
        }

        $meals = collect();
        foreach ($dinners->flatten() as $dinner) {
            $meals->add($dinner->meals);
        }

        return MealResource::collection($meals->flatten()->unique('id'));
    }
    public function getInfo()
    {
        $user = auth()->user();
        return new UserResource($user);
    }
}