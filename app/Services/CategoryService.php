<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class CategoryService
{

    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data): Category
    {
         $category->update($data);
         return $category;
    }

    public function restoreCategory($id)
    {
        $category = Category::onlyTrashed()->find($id);

        if ($category){
            $category->restore();
        }
        return $category;
    }

    public function permanentlyDeleteCategory($id)
    {
        $category = Category::withTrashed()->find($id);

        if ($category){
            $category->forceDelete();
        }

        return $category;
    }
}
