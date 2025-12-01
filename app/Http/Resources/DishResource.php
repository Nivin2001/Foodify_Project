<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DishResource extends JsonResource
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
            'image' => $this->image ? asset('uploads/dishes/' . $this->image) : null,
            'description' => $this->description,
            'price' => $this->price,
            'calories' => $this->calories,
            'protein' => $this->protein,
            'carbs' => $this->carbs,
            'fat' => $this->fat,
            'fiber' => $this->fiber,
            'rating' => $this->rating,
            'is_favorite' => $this->is_favorite,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'image' => $this->category->image ? asset('uploads/categories/' . $this->category->image) : null,
            ],
            'ingredients' => $this->ingredients->map(function($ingredient) {
                return [
                    'id' => $ingredient->id,
                    'name' => $ingredient->name,
                    'image' => $ingredient->image ? asset('uploads/ingredients/' . $ingredient->image) : null,
                ];
            }),
        ];
    }
}
