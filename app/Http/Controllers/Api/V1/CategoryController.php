<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:add_category')->only(['store']);
        $this->middleware('permission:view_category')->only(['index', 'show']);
        $this->middleware('permission:edit_category')->only(['update']);
        $this->middleware('permission:delete_category')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return CategoryResource::collection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return CategoryResource::make($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

        $category->load('subcategories');
        return CategoryResource::make($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
        if (!$category) {
            return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        $category->update($request->validated());

        return CategoryResource::make($category);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (!$category) {
            return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], Response::HTTP_OK);
    }
}