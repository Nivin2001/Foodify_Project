<?php
namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\UploadedFile;


class CategoryService
{
    protected $repo;

    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->getAll();
    }

    public function create(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        return $this->repo->create($data);
    }
  public function update(Category $category, array $data): Category
    {
        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->uploadImage($data['image']);
        }
        return $this->repo->update($category, $data);
    }
    public function delete($category)
    {
        return $this->repo->delete($category);
    }

    private function uploadImage($image)
    {
        $filename = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('uploads/categories'), $filename);
        return $filename;
    }

}

