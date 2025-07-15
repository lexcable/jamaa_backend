<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $totals = [
            'totalSales' => '$7,181,393.32',
            'totalProfit' => '$802,740.52',
            'profitPercentage' => '11.18%',
            'rating' => '6.511',
        ];

        $monthlySales = [
            534470, 356344, 598341, 693341, 621226, 599415,
            933516, 598416, 539406, 605404, 0, 0
        ];

        $categorySales = [
            'Electronics' => 1562912,
            'Computers' => 1200000,
            'Home & Kitchen' => 900000,
            'Baby' => 600000
        ];

        $genderDistribution = [
            'Female' => 50.01,
            'Male' => 49.99
        ];

        $paymentMethods = [
            'Cash' => 50.01,
            'Credit Card' => 49.99
        ];

        $customerTypes = [
            'New Customers' => 60,
            'Returning Customers' => 40
        ];

        $topProducts = [
            'Product A',
            'Product B',
            'Product C',
            'Product D'
        ];

        $topCategories = [
            'Category A',
            'Category B',
            'Category C',
            'Category D'
        ];

        return view('admin.sales', [
            'totals' => $totals,
            'monthlySales' => $monthlySales,
            'categorySales' => $categorySales,
            'genderDistribution' => $genderDistribution,
            'paymentMethods' => $paymentMethods,
            'customerTypes' => $customerTypes,
            'topProducts' => $topProducts,
            'topCategories' => $topCategories,
            'totalSales' => $totals['totalSales'],  
        ]);
    }
}
