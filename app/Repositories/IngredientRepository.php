<?php
namespace App\Repositories;
use App\Models\Dish;

class IngredientRepository
{
    public function createForDish(Dish $dish, array $ingredients)
    {
        foreach($ingredients as $ingredientData) {
            $dish->ingredients()->create([
                'name' => $ingredientData['name'],
                'image' => $ingredientData['image'] ?? null,
            ]);
        }
    }
}


?>
