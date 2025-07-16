@extends('layouts.app')

@section('title', 'Stock Reports')

@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Stock Reports</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="bg-gray-100 rounded-xl p-4">
            <h2 class="font-bold text-gray-700 mb-2">Stock vs. Sold Chart</h2>
            <canvas id="inventoryChart"></canvas>
        </div>
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
@endsection
