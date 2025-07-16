@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-2xl shadow-xl mt-8">
    <h2 class="text-3xl font-bold text-center text-indigo-600 mb-6">Add New Product</h2>

    <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Product Name -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Product Name</label>
            <input type="text" name="name" placeholder="e.g. Samsung Galaxy S21"
                class="w-full px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-300 focus:outline-none">
        </div>

        <!-- Category -->
        <div class="mb-4">
    <label for="category_id" class="block font-medium text-gray-700 mb-1">Category</label>
    <select id="category_id" name="category_id" required
        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-800">
        <option value="" disabled selected>Select Category</option>
        <option value="Groceries">Groceries</option>
        <option value="Cooking essentials">Cooking essentials</option>
        <option value="Fresh Produce">Fresh Produce</option>
        <option value="Bakery">Bakery</option>
        <option value="Butchery & Meat">Butchery & Meat</option>
        <option value="Dairy Products">Dairy Products</option>
        <option value="Frozen Foods">Frozen Foods</option>
        <option value="Beverages & Drinks">Beverages & Drinks</option>
        <option value="Personal Care">Personal Care</option>
        <option value="Household Supplies">Household Supplies</option>
        <option value="Baby Products">Baby Products</option>
        <option value="Electronics & Appliances">Electronics & Appliances</option>
        <option value="Home & Living">Home & Living</option>
    </select>
</div>


        <!-- Description -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Description</label>
            <textarea name="description" rows="4" placeholder="Write a short description..."
                class="w-full px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-300 focus:outline-none"></textarea>
        </div>

        <!-- Price -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Price (KES)</label>
            <input type="number" name="price" placeholder="e.g. 1999"
                class="w-full px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-300 focus:outline-none">
        </div>

        <!-- Image URL -->
                <!-- Upload Image Locally -->
        <div class="mb-4">
            <label for="image_file" class="block font-medium text-gray-700 mb-1">Upload Image (Local)</label>
            <input type="file" id="image_file" name="image_file"
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-800">
        </div>

        <!-- Or Provide Image URL -->
        <div class="mb-4">
            <label for="image_url" class="block font-medium text-gray-700 mb-1">Or Image URL</label>
            <input type="url" id="image_url" name="image_url" placeholder="https://example.com/image.jpg"
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-800">
        </div>

        <!-- Or Paste Google Drive Shareable Link -->
        <div class="mb-4">
            <label for="image_drive" class="block font-medium text-gray-700 mb-1">Or Google Drive Link</label>
            <input type="url" id="image_drive" name="image_drive" placeholder="https://drive.google.com/..."
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-800">
        </div>


        <!-- Stock -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Stock Quantity</label>
            <input type="number" name="stock" placeholder="Enter available stock"
                class="w-full px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-300 focus:outline-none">
        </div>

        <!-- Reorder Point -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Reorder Point</label>
            <input type="number" name="reorder_point" placeholder="Enter reorder point"
                class="w-full px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-300 focus:outline-none">
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow-lg transition-all">
                Save Product
            </button>
        </div>
    </form>
</div>
@endsection
