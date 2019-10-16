<?php

namespace Api\Http\Controllers;


use App\Models\Dinner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DinnerResource;



class DinnerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request('from_date') && request('to_date')){
            $dinners = Dinner::whereBetween('date',[request('from_date'),request('to_date')])->get();
            return DinnerResource::collection($dinners);
        }

        return response()->json([
            'message' => "you should send date from - to",
            'code' => 203
        ], 200);
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
            $dinner = Dinner::create($request->all());

            if($request->items){
                foreach ($request->items as $item) {
                    $dinner->meals()->attach($item['id'],['type' => $item['type']]);
                }
                return response()->json([
                    'message' => "Thanks admin",
                    'code' => 200
                ], 200);
            }

        }
        return response()->json([
            'message' => "you don't have permison to do this request",
            'code' => 203
        ], 401);

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
    public function update(Request $request, Dinner $dinner)
    {
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