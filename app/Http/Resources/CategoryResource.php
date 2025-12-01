<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'image' => $this->image ? asset('uploads/categories/' . $this->image) : null,
        'dishes' => $this->dishes->map(function($dish) {
            return [
                'id' => $dish->id,
                'name' => $dish->name,
                'image' => $dish->image ? asset('uploads/dishes/' . $dish->image) : null,
                'price' => $dish->price,
                'rating' => $dish->rating,
            ];
        }),
    ];
}

}
