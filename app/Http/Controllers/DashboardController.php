<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'salesTotal' => 880,
            'expensesTotal' => 0,
            'stocksTotal' => 0,
            'revenue' => 880,
            'topItems' => [
                ['name' => 'BIC CRYSTAL BLUE', 'quantity' => 857, 'profit' => 4681, 'status' => 'GOOD'],
                ['name' => 'A4 200 PGS SL', 'quantity' => 788, 'profit' => 23210, 'status' => 'GOOD'],
                ['name' => 'A4 120 PGS SL', 'quantity' => 620, 'profit' => 16570, 'status' => 'LOW'],
                ['name' => 'MANILLA PAPER', 'quantity' => 595, 'profit' => 5819, 'status' => 'GOOD'],
                ['name' => 'DAMASA PENCIL', 'quantity' => 435, 'profit' => 1642, 'status' => 'GOOD'],
            ],
            'topCategories' => [
                ['name' => 'Shop Rent', 'amount' => 80000],
                ['name' => 'Shop Food Expense', 'amount' => 45930],
            ],
            'topCustomer' => [
                'name' => 'Walk-in Customer',
                'amount' => 880,
            ],
        ];

        return view('admin.dashboard', $data );
    }
}
