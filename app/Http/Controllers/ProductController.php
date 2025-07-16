<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display the product inventory dashboard.
     */
    public function index()
    {
        // Totals & stats
        $totalSold    = Product::sum('sold');
        $totalStock   = Product::sum('stock');
        $topProduct   = Product::orderByDesc('sold')->first();
        $topCategoryId = Product::groupBy('category_id')
            ->orderByRaw('SUM(sold) DESC')
            ->pluck('category_id')
            ->first();
        $topCategory  = $topCategoryId ? Category::find($topCategoryId) : null;

        // All products
        $products = Product::with('category')->get();

        return view('products.index', compact(
            'totalSold','totalStock','topProduct','topCategory','products'
        ));
    }

    /**
     * Show the "Add New Product" form.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'reorder_point' => 'nullable|integer|min:0',
            'image_file'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url'     => 'nullable|url',
            'image_drive'   => 'nullable|url',
        ]);

        // Image handling: file > URL > Drive
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products','public');
            $validated['image'] = '/storage/'.$path;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        } elseif ($request->filled('image_drive')) {
            $validated['image'] = $request->input('image_drive');
        } else {
            $validated['image'] = null;
        }

        // Defaults
        $validated['code'] = mt_rand(100000,999999);
        $validated['sold'] = 0;

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success','Product added successfully!');
    }

    /**
     * Show the edit form.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product','categories'));
    }

    /**
     * Update the product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'reorder_point' => 'nullable|integer|min:0',
            'image_file'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url'     => 'nullable|url',
            'image_drive'   => 'nullable|url',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products','public');
            $validated['image'] = '/storage/'.$path;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        } elseif ($request->filled('image_drive')) {
            $validated['image'] = $request->input('image_drive');
        }

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success','Product updated successfully!');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success','Product deleted successfully!');
    }
}
