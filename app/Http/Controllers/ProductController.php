<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $totalSold = Product::sum('sold');  // Ensure 'sold' column exists
        $totalStock = Product::sum('stock');
        $topProduct = Product::orderByDesc('sold')->first();

        $topCategoryId = Product::groupBy('category_id')
            ->orderByRaw('SUM(sold) DESC')
            ->limit(1)
            ->pluck('category_id')
            ->first();

        $topCategory = $topCategoryId 
            ? Category::find($topCategoryId)
            : null;

        $products = Product::all();

        return view('admin.product', [
            'totalSold' => $totalSold,
            'totalStock' => $totalStock,
            'topProduct' => $topProduct,
            'topCategory' => $topCategory,
            'products' => $products,
        ]);
    }
    // Show add product form
    public function create()
    {
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }

    // Handle form submission and redirect back
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            // 'image_file'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // 'image_url'   => 'nullable|url',
            // 'image_drive' => 'nullable|url',
        ]);

        // Handle Image Upload
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('products', 'public');
            $validated['image'] = '/storage/' . $imagePath;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        } elseif ($request->filled('image_drive')) {
            $validated['image'] = $request->input('image_drive');
        } else {
            $validated['image'] = null;  // Optional fallback
        }

        $validated['code'] = rand(100000, 999999);
        $validated['sold'] = 0;

        $response = Product::create($validated);

        // return redirect()->route('admin.product')->with('success', 'Product added successfully!');
        return response()->json([
            'message' => 'Product Saved',
            'product' => $response,
        ],201);
            
        
    }

}