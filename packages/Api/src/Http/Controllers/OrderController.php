<?php

namespace Api\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Str;
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

            $orders = Order::with('dinners','meals')->where('status','!=' , 'completed')->get();

            // $orders = $orders_collection->map(function ($order) {
            //     $dinners_today = $order->dinners()->where('date', today())->exists();

            //     if($dinners_today || $order->meals()->exists()){
            //         return $order;
            //     }
            //     return null;
            // })
            // ->reject(function ($order) {
            //     return empty($order);
            // });

        }else{
            $orders = Order::where('status','!=' , 'completed')->where('user_id', $user->id)->get();
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
        foreach ($request->orders as $orderRequest) {

            $orderRequest['number'] = 'Qi_'. Str::random(3). '_' .mt_rand(100, 9999);
            // dd($orderRequest);
            $order = Order::create($orderRequest);

            if($orderRequest['type'] == "dinner"){
                foreach ($orderRequest['items'] as $item) {
                    $order->dinners()->attach($item['id'],['qty' => $item['qty']]);
                }

            }else{
                foreach ($orderRequest['items'] as $item) {
                    $order->meals()->attach($item['id'],['qty' => $item['qty']]);
                }
            }

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
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $user = auth()->user();

        $order->update($request->all());
        return response()->json(['message' => "Order Updated!!"], 200);

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
