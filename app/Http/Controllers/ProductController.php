<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();
        return response()->json($product);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'type' => 'required',
        'description' => 'required',
        'price' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $validatedData = $request->all(); // Initialize $validatedData with all request data

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products_images', 'public');
        $validatedData['image'] = $imagePath;
    }

    // Make sure the 'name' field is set before attempting to create a new product
    if (!isset($validatedData['name'])) {
        return response()->json(['error' => 'Name field is required.'], 400);
    }

    try {
        $product = Product::create($validatedData);
        return response()->json($product, 201);
    } catch (QueryException $e) {
        return response()->json(['error' => 'Error creating product', 'message' => $e->getMessage()], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required',
        'type' => 'required',
        'description' => 'required',
        'price' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $validatedData = $request->all();

    // Handle image upload
    if ($request->hasFile('image')) {
        // Delete the existing image file
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Upload and store the new image file
        $imagePath = $request->file('image')->store('products_images', 'public');
        $validatedData['image'] = $imagePath;
    }

    try {
        $product->update($validatedData);

        // Refresh the product instance to reflect the changes in the response
        $product = $product->fresh();

        return response()->json(['message' => 'Product updated successfully', 'data' => $product]);
    } catch (QueryException $e) {
        return response()->json(['error' => 'Error updating product', 'message' => $e->getMessage()], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json(['message' => 'Product is deleted', 'data' => $product]);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Error deleting product', 'message' => $e->getMessage()], 500);
        }
    }
}