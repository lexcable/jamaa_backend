<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gradient-to-r from-purple-400 to-blue-500 min-h-screen p-6">

    <div class="bg-white rounded-xl shadow-lg p-6 max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">SALES DASHBOARD <span class="text-sm text-gray-500">Super Market Shop</span></h1>
        <p class="text-gray-500 mb-6">Current sales, profit, categories, and customer insights overview.</p>

        <!-- Totals -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-100 rounded-xl p-4">
                <p class="text-gray-600">Total Sales</p>
                <p class="text-xl font-bold">{{ $totalSales }}</p>
            </div>
            <div class="bg-green-100 rounded-xl p-4">
                <p class="text-gray-600">Total Profit</p>
                <p class="text-xl font-bold">{{ $totals['totalProfit'] }}</p>
            </div>
            <div class="bg-yellow-100 rounded-xl p-4">
                <p class="text-gray-600">Profit %</p>
                <p class="text-xl font-bold">{{ $totals['profitPercentage'] }}</p>
            </div>
            <div class="bg-purple-100 rounded-xl p-4">
                <p class="text-gray-600">Rating</p>
                <p class="text-xl font-bold">{{ $totals['rating'] }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap gap-4 mb-8">
            <select class="p-2 rounded border border-gray-300">
                <option>Year</option>
            </select>
            <select class="p-2 rounded border border-gray-300">
                <option>Month</option>
            </select>
            <select class="p-2 rounded border border-gray-300">
                <option>Weekly</option>
            </select>
            <select class="p-2 rounded border border-gray-300">
                <option>Daily</option>
            </select>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-gray-100 rounded-xl p-4">
                <h2 class="font-bold text-gray-700 mb-2">Monthly Sales</h2>
                <canvas id="monthlyChart"></canvas>
            </div>
            <div class="bg-gray-100 rounded-xl p-4">
                <h2 class="font-bold text-gray-700 mb-2">Category Sales</h2>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-gray-100 rounded-xl p-4">
                <h2 class="font-bold text-gray-700 mb-2">Gender Breakdown</h2>
                <canvas id="genderChart"></canvas>
            </div>
            <div class="bg-gray-100 rounded-xl p-4">
                <h2 class="font-bold text-gray-700 mb-2">Payment Methods</h2>
                <canvas id="paymentChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-gray-100 rounded-xl p-4">
                <h2 class="font-bold text-gray-700 mb-2">Customer Type</h2>
                <canvas id="customerTypeChart"></canvas>
            </div>
            <div class="bg-gray-100 rounded-xl p-4">
                <h2 class="font-bold text-gray-700 mb-2">Top Products</h2>
                <ul class="list-disc list-inside text-gray-700">
                    @foreach ($topProducts as $product)
                        <li>{{ $product }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="bg-gray-100 rounded-xl p-4">
            <h2 class="font-bold text-gray-700 mb-2">Top Categories</h2>
            <ul class="list-disc list-inside text-gray-700">
                @foreach ($topCategories as $category)
                    <li>{{ $category }}</li>
                @endforeach
            </ul>
        </div>

    </div>

    <script>
        const monthlySales = @json($monthlySales);
        const categorySales = @json(array_values($categorySales));
        const categoryLabels = @json(array_keys($categorySales));
        const genderData = @json(array_values($genderDistribution));
        const genderLabels = @json(array_keys($genderDistribution));
        const paymentData = @json(array_values($paymentMethods));
        const paymentLabels = @json(array_keys($paymentMethods));
        const customerTypeData = @json(array_values($customerTypes));
        const customerTypeLabels = @json(array_keys($customerTypes));

        new Chart(document.getElementById('monthlyChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Monthly Sales ($)',
                    data: monthlySales,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)'
                }]
            },
            options: { responsive: true }
        });

        new Chart(document.getElementById('categoryChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categorySales,
                    backgroundColor: ['#3B82F6', '#60A5FA', '#93C5FD', '#BFDBFE']
                }]
            },
            options: { responsive: true }
        });

        new Chart(document.getElementById('genderChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: genderLabels,
                datasets: [{
                    data: genderData,
                    backgroundColor: ['#F87171', '#60A5FA']
                }]
            },
            options: { responsive: true }
        });

        new Chart(document.getElementById('paymentChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: paymentLabels,
                datasets: [{
                    data: paymentData,
                    backgroundColor: ['#10B981', '#FBBF24', '#F87171']
                }]
            },
            options: { responsive: true }
        });

        new Chart(document.getElementById('customerTypeChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: customerTypeLabels,
                datasets: [{
                    data: customerTypeData,
                    backgroundColor: ['#34D399', '#60A5FA']
                }]
            },
            options: { responsive: true }
        });
    </script>

</body>
</html>
