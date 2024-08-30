<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:191'
        ]);

        $category = Category::create([
            'name' => $validatedData['name']
        ]);

        return response()->json(['message' => 'Category created successfully.', 'category' => $category], 201);
    }

    public function show(Category $category)
    {
        return response()->json($category, 200);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191'
        ]);

        $category->name = $request->input('name');

        $category->save();

        return response()->json(['message' => 'Category updated successfully'], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
