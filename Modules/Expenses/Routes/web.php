<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Expenses\Http\Controllers\ExpensesController;
use Modules\Expenses\Http\Controllers\ExpenseCategoryController;


Route::group(['middleware' => 'auth'], function () {
    Route::resource('expenses', ExpensesController::class);
    Route::resource('expenses-categories', ExpenseCategoryController::class);
    Route::get('expense/status/{id}', [ExpensesController::class, 'status'])->name('expenses.status');
    Route::get('expenseCategory/status/{id}', [ExpenseCategoryController::class, 'status'])->name('expenseCategory.status');
    Route::get('get-expenses', [ExpensesController::class,'getExpense'])->name('getExpenses');

});
