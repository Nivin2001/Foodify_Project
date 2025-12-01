<?php

namespace App\Services;

use App\Repositories\IngredientRepository;
use App\Models\Dish;

class IngredientService
{
    protected IngredientRepository $repo;

    public function __construct(IngredientRepository $repo)
    {
        $this->repo = $repo;
    }

  public function createForDish(Dish $dish, array $ingredients)
{
    // هنا بنمرر كل الـ ingredients مرة وحدة
    $this->repo->createForDish($dish, $ingredients);
}

}
