<?php

namespace App\Services;

use App\Models\CartItem;
use App\Repositories\CartRepository;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    protected CartRepository $repo;

    public function __construct(CartRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getUserCart(int $userId): Collection
    {
        return $this->repo->getUserCart($userId);
    }

    public function addToCart(int $userId, int $dishId, int $quantity)
    {
        return $this->repo->addToCart($userId, $dishId, $quantity);
    }

    public function updateQuantity(int $userId, int $cartItemId, int $quantity): CartItem
    {
        $cartItem = CartItem::where('id', $cartItemId)
            ->where('user_id', $userId)
            ->firstOrFail(); // لو مش موجود، يعطي 404 تلقائياً

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return $cartItem; // 🔹 Model مباشرة
    }
    public function removeFromCart(int $userId, int $cartItemId)
    {
        $this->repo->removeFromCart($cartItemId);
    }

    public function clearCart(int $userId)
    {
        $this->repo->clearCart($userId);
    }
}
