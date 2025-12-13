<?php

namespace App\Http\Controllers\API\Order;

use App\Events\OrderPlaced;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\OrderResource;
use App\Notifications\OrderNotification;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function myOrders(OrderService $service)
    {
        $orders = $service->getUserOrders(auth()->id());
        return OrderResource::collection($orders);
    }
    // evene,listener

    public function store(Request $request)
{
    $order = $this->service->createOrder($request->user()->id);

    if (!$order) {
        return response()->json(['message' => 'Cart is empty'], 400);
    }

    event(new OrderPlaced($order, "Your order #{$order->id} has been placed successfully!"));

         return response()->json([
        'order' => $order,
        'message' => 'Order placed and notification sent!',
    ]);

     // return response()->json([
        //     'order' => new \App\Http\Resources\OrderResource($order),
        //     'notification' => [
        //         'order_id' => $order->id,
        //      'message' => 'Order placed and notification sent!',
        //     ],
        // ]);
}


// without notification
    // public function store(Request $request)
    // {
    //     $order = $this->service->createOrder($request->user()->id);

    //     if (!$order) {
    //         return response()->json(['message' => 'Cart is empty'], 400);
    //     }
    //     $request->user()->notify(
    //         new OrderNotification($order, 'Your order has been placed successfully!')
    //     );

    //     $notifications = NotificationResource::collection(
    //         $request->user()->notifications()->latest()->take(5)->get()
    //     );


    //     return response()->json([
    //         'order' => new OrderResource($order),
    //         'notifications' => $notifications
    //     ]);
    // }
}

