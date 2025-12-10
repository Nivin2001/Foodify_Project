<?php

namespace App\Http\Controllers\API\Order;

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


    public function store(Request $request)
    {
        $order = $this->service->createOrder($request->user()->id);

        if (!$order) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }
        $request->user()->notify(
            new OrderNotification($order, 'Your order has been placed successfully!')
        );

        $notifications = NotificationResource::collection(
            $request->user()->notifications()->latest()->take(5)->get()
        );


        return response()->json([
            'order' => new OrderResource($order),
            'notifications' => $notifications
        ]);
    }
}
