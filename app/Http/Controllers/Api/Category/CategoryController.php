<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected CategoryService $categoryService;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        if (!auth()->user()->hasPermission('view-category')){
            return response()->json(['message' => 'You do not have permission to view categories'], 403);
        }

        $categories = Category::paginate(10);
        return response()->json(['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        if (!auth()->user()->hasPermission('create-category')){
            return response()->json(['message' => 'You don not have permission the create category'], 403);
        }

        $categories = $this->categoryService->createCategory($request->validated());
        return response()->json(['message' => 'Category created successfully', 'category' => $categories], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return JsonResponse|Category
     */
    public function show(Category $category): JsonResponse|Category
    {
        if (!auth()->user()->hasPermission('view-category')){
            return response()->json(['message' => 'You do not have permission to view categories'], 403);
        }

        return $category->load('books');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        if (!auth()->user()->hasPermission('edit-category')){
            return response()->json(['message' => 'You don not have permission the update category'], 403);
        }

        $data = $request->validated();
        $updatedCategory = $this->categoryService->updateCategory($category, $data);

        return response()->json(['message' => 'Category updated successfully', 'category' => $updatedCategory], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Category|JsonResponse
     */
    public function destroy(Category $category): Category|JsonResponse
    {
        if (!auth()->user()->hasPermission('delete-category')){
            return response()->json(['message' => 'You don not have permission the delete category'], 403);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function restore($id): JsonResponse
    {
        if (!auth()->user()->hasPermission('restore')){
            return response()->json(['message' => 'You don not have permission the restore category'], 403);
        }

        $category = $this->categoryService->restoreCategory($id);
        return response()->json(['message' => 'Category restored successfully', 'category' => $category], 200);
    }

    /**
     * @return array|Collection|JsonResponse
     */
    public function getDeletedCategories(): array|Collection|JsonResponse
    {
        if (!auth()->user()->hasPermission('view-deleted-data')){
            return response()->json(['message' => 'You don not have permission the view deleted categories'], 403);
        }

        return Category::onlyTrashed()->get();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function forceDelete($id): JsonResponse
    {
        if (!auth()->user()->hasRole('admin')){
            return response()->json(['message' => 'You don not have permission the delete category'], 403);
        }

        $this->categoryService->permanentlyDeleteCategory($id);
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
