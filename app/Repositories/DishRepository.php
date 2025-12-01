<?php
namespace App\Repositories;

use App\Models\Dish;

class DishRepository
{
    public function getTopRated(int $limit = 3)
    {
        return Dish::orderBy('rating', 'desc')->take($limit)->get();
    }
    public function getAll()
    {
        return Dish::with('ingredients', 'category')->get();
    }

    public function create(array $data): Dish
    {
        return Dish::create($data);
    }

    public function update(Dish $dish, array $data): Dish
    {
        $dish->update($data);
        return $dish;
    }

    public function delete(Dish $dish): ?bool
    {
        return $dish->delete();
    }
}

?>
