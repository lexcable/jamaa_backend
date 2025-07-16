<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BudgetController;
// use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\CustomerController;


Route::resource('products', ProductController::class);

Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');


Route::resource('customers', CustomerController::class)->only(['index','show','create','store']);

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/sales', [SalesController::class, 'index'])->name('admin.sales');
Route::get('/budget', [BudgetController::class, 'index'])->name('budget.index');
// Route::get('/expenses', [ExpensesController::class, 'index'])->name('expenses.index');
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
Route::get('/reports/stock', [ReportsController::class, 'stockReport'])->name('reports.stock');
Route::get('/reports/revenue', [ReportsController::class, 'revenueReport'])->name('reports.revenue');
Route::get('/reports/expenses', [ReportsController::class, 'expenseReport'])->name('reports.expenses');


// Route::get('/products', [ProductController::class, 'index'])->name('admin.product');
// Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
// Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
// Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
// Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
// Route::delete('/products/{id}/destroy', [ProductController::class, 'destroy'])->name('products.destroy');

//Route::resource('products', ProductController::class)->only(['index','create','store','edit','update','destroy']);
