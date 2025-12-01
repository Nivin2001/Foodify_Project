<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $categories = $this->service->getAll();
        return CategoryResource::collection($categories);
    }

    public function store(CategoryRequest $request)
    {
        $category = $this->service->create($request->validated());
          return new CategoryResource($category);
    return response()->json([
        'message' => 'Category added successfully',
    ], 201); // 201 = Created
    }
       public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->all(); // form-data + file
        $updated = $this->service->update($category, $data);
        return new CategoryResource($updated);
    }

    public function destroy(Category $category)
    {
        $this->service->delete($category);
        return response()->json(['message' => 'Category deleted successfully']);
    }


}
