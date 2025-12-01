<?php

namespace App\Http\Controllers\API\Dish;

use App\Http\Controllers\Controller;
use App\Http\Requests\DishRequest;
use App\Http\Resources\DishResource;
use App\Services\DishService;
use App\Models\Dish;

class DishController extends Controller
{
    protected DishService $service;

    public function __construct(DishService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $dishes = $this->service->getAll();
        return DishResource::collection(
            Dish::with(['category', 'ingredients'])->get()
        );
    }
    public function store(DishRequest $request)
    {

        $data = $request->all();

        if (isset($data['ingredients']) && is_string($data['ingredients'])) {
            $data['ingredients'] = json_decode($data['ingredients'], true);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('dishes', 'public');
        }

        $dish = $this->service->createDishWithIngredients($data);
        return new DishResource($dish);

        // return response()->json([
        //     'message' => 'Dish added successfully',
        // ], 201); // 201 = Created
    }

    public function update(DishRequest $request, Dish $dish)
    {
        $data = $request->all();
        $updated = $this->service->update($dish, $data);
        return new DishResource($updated);
    }

    public function destroy(Dish $dish)
    {
        $this->service->delete($dish);
        return response()->json(['message' => 'Dish deleted successfully']);
    }

    public function topRated()
    {
        $dishes = $this->service->getTopRated();
        return DishResource::collection($dishes);
    }
}
