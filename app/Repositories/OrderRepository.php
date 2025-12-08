<?php
namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;

class OrderRepository
{
  public function getUserOrders($userId)
{
    // ترتيب حسب العمود created_at تنازليًا (الأحدث أول)
    return Order::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
}


    public function createOrder(int $userId)
    {
        $cartItems = CartItem::with('dish')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return null; // no items
        }

        $subtotal = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item->dish->price * $item->quantity;
        }

        $delivery = 5;
        $total = $subtotal + $delivery;

        // Create order
        $order = Order::create([
            'user_id' => $userId,
            'subtotal' => $subtotal,
            'delivery' => $delivery,
            'total' => $total,
            'status' => 'pending'
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'  => $order->id,
                'dish_id'   => $item->dish_id,
                'quantity'  => $item->quantity,
                'price'     => $item->dish->price
            ]);
        }

        // Clear cart
        CartItem::where('user_id', $userId)->delete();

        return $order;
    }
}
?>
