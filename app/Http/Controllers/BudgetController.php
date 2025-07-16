<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BudgetController extends Controller
{
    /**
     * Display the budget manager.
     */
    public function index(Request $request)
    {
        // Define categories and items
        $categories = [
            'revenue' => [
                'label' => 'Revenue Sources',
                'items' => [
                    'product_sales'   => 'Product Sales',
                    'wholesale_sales' => 'Wholesale Sales',
                    'rental_income'   => 'Rental Income',
                    'other_income'    => 'Other Income',
                ],
            ],
            'expenses' => [
                'label' => 'Operating Expenses',
                'items' => [
                    'inventory'       => 'Inventory Purchases',
                    'staff_salaries'  => 'Staff Salaries',
                    'utilities'       => 'Utilities',
                    'rent'            => 'Rent/Lease',
                    'marketing'       => 'Marketing',
                    'security'        => 'Security Services',
                    'insurance'       => 'Insurance',
                    'bank_fees'       => 'Bank Fees',
                    'permits'         => 'Licenses & Permits',
                    'transportation'  => 'Transportation',
                    'maintenance'     => 'Repairs & Maintenance',
                    'it'              => 'Software & IT',
                ],
            ],
            'assets' => [
                'label' => 'Assets',
                'items' => [
                    'cash'             => 'Cash on Hand',
                    'bank_savings'     => 'Bank Savings',
                    'inventory_value'  => 'Inventory Value',
                    'receivables'      => 'Accounts Receivable',
                    'prepaid'          => 'Prepaid Expenses',
                    'misc_assets'      => 'Miscellaneous Assets',
                    'equipment'        => 'Equipment Value',
                    'improvements'     => 'Store Improvements',
                    'investments'      => 'Investments',
                    'depreciation'     => 'Depreciation',
                    'goodwill'         => 'Goodwill',
                ],
            ],
            'liabilities' => [
                'label' => 'Liabilities',
                'items' => [
                    'payables'        => 'Supplier Payables',
                    'loans'           => 'Short-term Loans',
                    'taxes'           => 'Outstanding Taxes',
                    'benefits'        => 'Employee Benefits',
                    'other_debts'     => 'Other Debts',
                ],
            ],
            'equity' => [
                'label' => 'Equity/Capital',
                'items' => [
                    'owners_equity'   => 'Owner’s Equity',
                    'retained'        => 'Retained Earnings',
                ],
            ],
        ];

        // Actual values (hardcoded or pulled from DB)
        $actuals = [
            'revenue' => [800000, 200000, 50000, 20000],
            'expenses'=> [500000, 200000, 60000, 100000, 30000, 20000, 15000, 10000, 5000, 40000, 10000, 20000],
            'assets'  => [120000, 450000, 700000, 80000, 50000, 20000, 350000, 200000, 300000, -100000, 150000],
            'liabilities'=> [200000,100000,80000,30000,50000],
            'equity'  => [1000000,300000],
        ];

        // Retrieve saved targets from session or set defaults to 0
        $targets = Session::get('budget_targets', array_map(function($cat) {
            return array_fill(0, count($cat['items']), 0);
        }, $categories));

        return view('admin.budget', compact('categories','actuals','targets'));
    }

    /**
     * Update budget targets in session.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'targets' => 'required|array',
            'targets.*' => 'array',
            'targets.*.*' => 'nullable|numeric|min:0',
        ]);

        // Store in session
        Session::put('budget_targets', $data['targets']);

        return redirect()->back()->with('success', 'Budget targets updated successfully.');
    }
}
