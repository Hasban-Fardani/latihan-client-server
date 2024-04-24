<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json([
            'message' => 'Success get all categories',
            'categories' => Category::latest()->get(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors()
            ], 422);
        }

        $category = Category::create($validator->validated());
        
        return response()->json([
            'message' => 'Success create category', 
            'category' => $category 
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors()
            ], 422);
        }

        $category->update($validator->validated());
        
        return response()->json([
            'message' => 'Success create category', 
            'category' => $category 
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'Success delete category', 
        ], 200);
    }
}
