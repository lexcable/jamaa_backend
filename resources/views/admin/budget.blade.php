<!-- resources/views/budget.blade.php -->
@extends('layouts.app')

@section('title', 'Supermarket Budget Manager')

@section('content')
<div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-8">
    <!-- Charts Section (Left) -->
    <div class="md:w-2/3 space-y-8">
        <h1 class="text-3xl font-bold">Supermarket Budget Manager</h1>
        @foreach($categories as $categoryKey => $category)
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-2xl font-semibold capitalize mb-4">{{ $category['label'] }}</h2>
                <canvas id="chart-{{ $categoryKey }}"></canvas>
            </div>
        @endforeach
    </div>

    <!-- Budget Input Form (Right) -->
    <div class="md:w-1/3">
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-semibold mb-4">Set Budget Targets</h2>
            <form action="{{ url()->current() }}" method="POST" class="space-y-4">
                @csrf
                @foreach($categories as $categoryKey => $category)
                    <div class="border-b pb-4">
                        <h3 class="text-xl font-medium capitalize mb-2">{{ $category['label'] }}</h3>
                        @foreach($category['items'] as $itemKey => $itemLabel)
                            <div class="flex items-center space-x-4 mb-2">
                                <label class="w-1/2">{{ $itemLabel }} (KES)</label>
                                <input type="number" name="targets[{{ $categoryKey }}][{{ $itemKey }}]" 
                                    value="{{ old("targets.$categoryKey.$itemKey", $targets[$categoryKey][$itemKey] ?? 0) }}"
                                    class="border rounded p-1 w-1/2" min="0" />
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded w-full">Save Targets</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Data from controller
        const budgets   = @json($targets);
        const actuals   = @json($actuals);
        const categories= @json($categories);

        Object.entries(categories).forEach(([key, cat]) => {
            const labels      = Object.values(cat.items);
            const actualData  = actuals[key]   || [];
            const targetData  = budgets[key]   || [];

            const maxVal = Math.max(...actualData, ...targetData);
            const step   = Math.ceil(maxVal / 5);

            const ctx = document.getElementById(`chart-${key}`).getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Actual',
                            data: actualData,
                            backgroundColor: 'rgba(59,130,246,0.7)', // Tailwind blue-500
                            barThickness: 20
                        },
                        {
                            label: 'Target',
                            data: targetData,
                            backgroundColor: 'rgba(37,99,235,0.7)',   // Tailwind blue-600
                            barThickness: 20
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: { stepSize: step },
                            title: {
                                display: true,
                                text: 'Amount (KES)',
                                font: { weight: 'bold' }
                            }
                        }
                    }
                }
            });
        });
    });
</script>
@endsection
