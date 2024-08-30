<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories', 'features')->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:191',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'integer|exists:categories,id',
            'features' => 'nullable|array',
            'features.*' => 'string',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'title' => $validatedData['title'],
            'image' => $imagePath,
        ]);

        $categories = $request->input('categories');
        $product->categories()->sync($categories);

        if (!empty($validatedData['features'])) {
            foreach ($validatedData['features'] as $feature) {
                $product->features()->create(['description' => $feature]);
            }
        }

        return response()->json(['message' => 'Product created successfully.', 'product' => $product], 201);
    }

    public function show(Product $product)
    {
        $product->load(['categories', 'features']);

        return response()->json($product, 200);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:191',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $product->title = $request->input('title');


        if ($request->hasFile('image')) {
            $imagePath = $product->image;

            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return response()->json(['message' => 'Product updated successfully'], 200);
    }

    public function destroy(Product $product)
    {
        $imagePath = $product->image;

        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
