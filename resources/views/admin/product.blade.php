@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow p-6">

        <h1 class="text-2xl font-bold mb-4">Product Inventory Dashboard</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-100 p-4 rounded-xl">
                <p>Total Products Sold:</p>
                <p class="font-bold text-xl">{{ $totalSold }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-xl">
                <p>Total Stock Remaining:</p>
                <p class="font-bold text-xl">{{ $totalStock }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-xl">
                <p>Top Selling Product:</p>
<p class="font-bold">{{ $topProduct->name ?? '' }}</p>
            </div>
            <div class="bg-purple-100 p-4 rounded-xl">
                <p>Top Selling Category:</p>
                <p class="font-bold">
{{ $topCategory->name ?? '' }}
                </p>
            </div>
        </div>

        <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded inline-block mb-4">Add New Product</a>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-left border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">Image</th>
                        <th class="p-2 border">Name</th>
                        <th class="p-2 border">Category</th>
                        <th class="p-2 border">Price</th>
                        <th class="p-2 border">Stock</th>
                        <th class="p-2 border">Reorder Point</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Sold</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="border p-2">
                                @if($product->image)
                                    <img src="{{ $product->image }}" class="w-16 h-16 object-cover rounded">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="border p-2">{{ $product->name }}</td>
                            <td class="border p-2">{{ $product->category->name ?? 'N/A' }}</td>
                            <td class="border p-2">{{ $product->price }}</td>
                            <td class="border p-2">{{ $product->stock }}</td>
                            <td class="border p-2">{{ $product->reorder_point ?? 0 }}</td>
                            <td class="border p-2">
                                @php
                                    $stock = $product->stock;
                                    $reorder = $product->reorder_point ?? 0;
                                    if ($stock == 0) {
                                        $status = 'Stagnant';
                                        $class = 'bg-gray-200 text-gray-800';
                                    } elseif ($stock <= $reorder) {
                                        $status = 'Low Stock';
                                        $class = 'bg-yellow-200 text-yellow-800';
                                    } else {
                                        $status = 'In Stock';
                                        $class = 'bg-green-200 text-green-800';
                                    }
                                @endphp
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $class }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="border p-2">{{ $product->sold }}</td>
                            <td class="border p-2 space-x-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Chart Section -->
        <div class="bg-gray-100 rounded-xl mt-8 p-4">
            <h2 class="text-lg font-bold mb-2">Stock vs. Sold Chart</h2>
            <canvas id="inventoryChart"></canvas>
        </div>

    </div>

    <script>
        const ctx = document.getElementById('inventoryChart').getContext('2d');

        const inventoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($products->pluck('name')) !!},
                datasets: [{
                    label: 'Stock',
                    data: {!! json_encode($products->pluck('stock')) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.7)'
                },
                {
                    label: 'Sold',
                    data: {!! json_encode($products->pluck('sold')) !!},
                    backgroundColor: 'rgba(34, 197, 94, 0.7)'
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>

</body>
</html>
@endsection
