<?php

namespace Api\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if (\Gate::allows('isAdmin', $user)) {

            $orders = Order::where('status', false)->get();
        }else{
            $orders = Order::where('user_id', $user->id)->get();
        }

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add(['number' => time()]);
        $order = Order::create($request->all());

        foreach ($request->items as $item) {
            $order->meals()->attach($item['id'],['qty' => $item['qty']]);
        }

        return response()->json(['message' => "Thanks our agent reply you very soon"], 200);

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
    public function update(Request $request, Order $order)
    {
        $user = auth()->user();
        if (\Gate::allows('isAdmin', $user)) {

            $order->update($request->all());
            return response()->json(['message' => "Order Updated!!"], 200);

        }

        return response()->json([
            'message' => "you don't have permison to do this request",
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
