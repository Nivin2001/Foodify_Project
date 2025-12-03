<?php

namespace App\Repositories;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Collection;

class CartRepository
{
    public function getUserCart(int $userId): Collection
    {
        return CartItem::with('dish')->where('user_id', $userId)->get();
    }
    public function addToCart(int $userId, int $dishId, int $quantity): CartItem
    {
        $cartItem = CartItem::where('user_id', $userId)
            ->where('dish_id', $dishId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
            return $cartItem;
        }

        return CartItem::create([
            'user_id' => $userId,
            'dish_id' => $dishId,
            'quantity' => $quantity,
        ]);
    }


    public function updateQuantity(int $cartItemId, int $quantity): CartItem
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->quantity = $quantity;
        $cartItem->save();
        return $cartItem;
    }

    public function removeFromCart(int $cartItemId): void
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->delete();
    }

    public function clearCart(int $userId): void
    {
        CartItem::where('user_id', $userId)->delete();
    }
}
