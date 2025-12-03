<?php

namespace App\Http\Controllers\API\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $service;

    public function __construct(CartService $service)
    {
        $this->service = $service;
    }
    public function index(Request $request)
    {
        $cartItems = $this->service->getUserCart($request->user()->id);
        return CartItemResource::collection($cartItems);
    }
    public function store(CartItemRequest $request)
    {
        $this->service->addToCart($request->user()->id, $request->dish_id, $request->quantity);
        return response()->json(['message' => 'Dish added to cart successfully'], 201);
    }
    public function update(CartItemRequest $request, $cartItemId)
    {
        $updatedCartItem = $this->service->updateQuantity(
            $request->user()->id,
            (int)$cartItemId,
            $request->quantity
        );

        return new CartItemResource($updatedCartItem); // 🔹 Resource
    }
    public function destroy($cartItemId)
    {
        $this->service->removeFromCart(auth()->id(), (int)$cartItemId);
        return response()->json(['message' => 'Cart item removed successfully']);
    }

    public function clear(Request $request)
    {
        $this->service->clearCart($request->user()->id);
        return response()->json(['message' => 'Cart cleared successfully']);
    }
}
