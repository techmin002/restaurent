<?php

use Illuminate\Support\Facades\Route;
use Modules\Restaurent\Http\Controllers\CustomerController;
use Modules\Restaurent\Http\Controllers\MenuController;
use Modules\Restaurent\Http\Controllers\OfficeRegisterController;
use Modules\Restaurent\Http\Controllers\OrderController;
use Modules\Restaurent\Http\Controllers\PosController;
use Modules\Restaurent\Http\Controllers\RestaurentController;
use Modules\Restaurent\Http\Controllers\RestaurentTableController;
use Modules\Restaurent\Http\Controllers\SectionController;
use Modules\Restaurent\Http\Controllers\ReceptionController;
use Modules\Restaurent\Http\Controllers\KitchenController;
use Modules\Restaurent\Http\Controllers\DueOrderController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('restaurents', RestaurentController::class)->names('restaurent');
    Route::resource('sections', SectionController::class)->names('sections');
    Route::resource('tables', RestaurentTableController::class)->names('tables');
    Route::resource('menus', MenuController::class)->names('menus');
    Route::resource('offices', OfficeRegisterController::class)->names('offices');
    Route::resource('customers', CustomerController::class)->names('customers');
    // Route::get('pos', [PosController::class,'index'])->name('pos.index');
   // Order Management Routes
Route::get('new/order', [OrderController::class, 'create'])->name('neworders');
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('kitchen/orders', [OrderController::class, 'kitchenOrders'])->name('kitchenorders');
Route::get('reception/orders', [OrderController::class, 'receptionOrders'])->name('receptionorders');
Route::get('completed/orders', [OrderController::class, 'completedOrders'])->name('completedorders');


    Route::get('api/tables', [OrderController::class, 'getTables']);
    Route::get('api/offices', [OrderController::class, 'getOffices']);
    Route::get('api/customers', [OrderController::class, 'getCustomers']);
    Route::get('api/products/search', [OrderController::class, 'getProducts']);
    Route::post('/api/customers/store', [OrderController::class, 'storeCustomer']);
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('api/products/{id}', [OrderController::class, 'show']);
    Route::get('/check-latest-order', [OrderController::class, 'checkLatestOrder']);


    Route::get('table/order', [RestaurentTableController::class, 'order'])->name('table.order');

    Route::post('/reception/serve/{id}', [ReceptionController::class, 'markServed']);
    Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
    Route::post('/kitchen/start/{order}', [KitchenController::class, 'start'])->name('kitchen.start');
Route::post('/kitchen/served/{id}', [KitchenController::class, 'markServed'])->name('kitchen.markServed');

Route::post('/orders/update-payment', [OrderController::class, 'updatePayment'])->name('orders.updatePayment');
Route::post('/orders/{id}/kitchen', [OrderController::class, 'moveToKitchen'])
    ->name('orders.moveToKitchen');
Route::get('/duecustomers', [DueOrderController::class, 'index'])->name('duecustomers');
    Route::post('/reception/restaurent/due/pay/{id}', [OrderController::class, 'payDue'])->name('due.pay');
    Route::post('/customers/pay-due', [CustomerController::class, 'payDue'])
     ->name('customers.payDue');

});

