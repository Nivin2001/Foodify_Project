<?php
namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $order = $this->service->createOrder($request->user()->id);

        if (!$order) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        return new OrderResource($order);
    }
}


