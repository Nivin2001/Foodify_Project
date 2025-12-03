<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
public function toArray($request): array
    {
        $dish = $this->dish;

        $subtotal = $dish->price * $this->quantity;
        $delivery = 5; // ثابت كمثال
        $total = $subtotal + $delivery;

        return [
            'id' => $this->id,
            'dish' => [
                'id' => $dish->id,
                'name' => $dish->name,
                'price' => $dish->price,
                'image' => $dish->image ? asset('uploads/dishes/' . $dish->image) : null,
            ],
            'quantity' => $this->quantity,
            'subtotal' => $subtotal,
            'delivery' => $delivery,
            'total' => $total,
        ];
    }

}
