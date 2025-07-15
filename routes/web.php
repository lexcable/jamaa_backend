<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ReportsController;

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/sales', [SalesController::class, 'index'])->name('admin.sales');
Route::get('/budget', [BudgetController::class, 'index'])->name('budget.index');
Route::get('/expenses', [ExpensesController::class, 'index'])->name('expenses.index');
Route::get('/stocks', [StocksController::class, 'index'])->name('stocks.index');
Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
Route::get('/customers', [CustomersController::class, 'index'])->name('customers.index');
Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');

Route::get('/products', [ProductController::class, 'index'])->name('admin.product');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}/destroy', [ProductController::class, 'destroy'])->name('products.destroy');

