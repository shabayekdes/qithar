<?php

namespace Api\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MealResource;


class MealController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(request('cat_id')){
            $meals = Meal::where('category_id', request('cat_id'))->get();
        }else{
            $meals = Meal::all();
        }

        return MealResource::collection($meals);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if (\Gate::allows('isAdmin', $user)) {
            return Meal::create($request->all());
        }

        return response()->json([
            'message' => "you don't have permison to do this request",
            'code' => 203
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meal $meal)
    {
        $rating = $meal->rating + $request->rating;
        $request->merge(['rating' => $rating ]);
        $request->merge(['rating_count' => ++$meal->rating_count ]);
        $meal->update($request->all());

        return response()->json([
            'message' => "Thanks!!",
            'code' => 203
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
