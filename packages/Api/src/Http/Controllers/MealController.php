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
        }if(request('type')){
            $meals = Meal::where('type', request('type'))->get();
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

            $rules = array(
                'avatar' => 'mimes:jpeg,png'
            );
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->messages(), 404);
            }

            $meal = Meal::create($request->all());

            $pathToDatabase = null;

            if($request->hasFile('image')){


                $fileNameWihtExt = $request->file('image')->getClientOriginalName();
                $fileName = pathinfo($fileNameWihtExt, PATHINFO_FILENAME);

                $extension = $request->file('image')->getClientOriginalExtension();

                $fileNameToStore = 'meal_'.$meal->id.'.'. $extension;

                $path = $request->file('image')->storeAs('public/img/meals', $fileNameToStore);
                $pathToDatabase = url('storage/img/meals/'. $fileNameToStore);
            }

            $meal->update([
                'image' => $pathToDatabase
            ]);

            return response()->json([
                'message' => 'Thanks meal stored',
                'code' => 200
            ], 200);



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
    public function update(Request $request, $id)
    {
        $meal = Meal::findOrFail($id);
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