<?php
namespace App\Services;

use App\Repositories\DishRepository;
use App\Services\IngredientService;
use App\Models\Dish;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class DishService
{
    protected DishRepository $repo;
  protected IngredientService $ingredientService;

public function __construct(DishRepository $repo, IngredientService $ingredientService)
{
    $this->repo = $repo;
    $this->ingredientService = $ingredientService;
}

  public function createDishWithIngredients(array $data)
{
    $ingredients = $data['ingredients'] ?? [];

    $dishData = $data;
    unset($dishData['ingredients']);

    $dish = Dish::create($dishData);

    if (!empty($ingredients)) {
        $this->ingredientService->createForDish($dish, $ingredients);
    }
    return Dish::with(['category', 'ingredients'])->find($dish->id);
}

 public function getTopRated(int $limit = 3)
    {
        return $this->repo->getTopRated($limit);
    }


    public function getAll()
    {
        return $this->repo->getAll();
    }

    public function create(array $data): Dish
    {
        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->uploadImage($data['image']);
        }
        return $this->repo->create($data);
    }

    public function update(Dish $dish, array $data): Dish
    {
        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->uploadImage($data['image']);
        }
        return $this->repo->update($dish, $data);
    }

    public function delete(Dish $dish): ?bool
    {
        return $this->repo->delete($dish);
    }

    private function uploadImage(UploadedFile $image): string
    {
        $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME))
                    . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/dishes'), $filename);
        return $filename;
    }
}

?>
