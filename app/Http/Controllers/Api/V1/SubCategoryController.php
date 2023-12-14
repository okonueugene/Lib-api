<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubCategoryResource;
use App\Http\Requests\StoreSubCategoryRequest;

class SubCategoryController extends Controller
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
        return SubCategoryResource::collection(SubCategory::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubCategoryRequest $request)
    {
        $subcategory = SubCategory::create($request->validated());

        return SubCategoryResource::make($subcategory);


    }
    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subcategory)
    {
        //
        $subcategory->load('category');
        return SubCategoryResource::make($subcategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }
}