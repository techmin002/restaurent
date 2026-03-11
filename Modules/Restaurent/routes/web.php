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

    // Customer Management Routes
    Route::post('/check-customer-by-phone', [OrderController::class, 'checkCustomerByPhone'])->name('check.customer.by.phone');
    Route::get('/api/customers/{customerId}/recent-orders', [OrderController::class, 'getCustomerRecentOrders']);

    // Resource Routes
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

    Route::resource('orders', OrderController::class)->names('orders');

    // Category Management Routes
    Route::get('categories/index', [MenuController::class, 'categoriesIndex'])->name('categories.index');
    Route::post('categories/store', [MenuController::class, 'categories_store'])->name('categories.store');
    Route::get('categories/{id}/edit', [MenuController::class, 'categories_edit'])->name('categories.edit');
    Route::put('categories/{id}/update', [MenuController::class, 'categories_update'])->name('categories.update');
    Route::delete('categories/{id}/destroy', [MenuController::class, 'categories_destroy'])->name('categories.destroy');
    

    // Order Management Routes
    Route::get('new/order', [OrderController::class, 'create'])->name('neworders');
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

    // Universal Order Routes (Handles all order types)
    // Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

    // Menu Page Order Routes
    Route::post('/orders/menus/store', [OrderController::class, 'storeMenuOrder'])->name('orders.menus.store');
    Route::post('/orders/menus/update', [OrderController::class, 'updateMenuOrder'])->name('orders.menus.update');

    // Specific Order Pages
    Route::get('create/orders', [OrderController::class, 'createNewOrder'])->name('createorders');
    Route::get('tab/order/{id}', [RestaurentController::class, 'table_order'])->name('tab.order');
    Route::get('office/order/{id}', [RestaurentController::class, 'office_order'])->name('office.order');

    // Specific Order Submission Routes (Legacy)
    Route::post('office/orders/submit', [OrderController::class, 'office_orders_submit'])->name('office.orders.submit');
    Route::post('tables/orders/submit', [OrderController::class, 'table_orders_submit'])->name('tables.orders.submit');
    Route::post('/tables/orders/update', [OrderController::class, 'table_orders_update'])->name('tables.orders.update');
    Route::post('/office/orders/update', [OrderController::class, 'office_orders_update'])->name('office.orders.update');
    Route::get('/api/office/{officeId}/recent-orders', [OrderController::class, 'getOfficeRecentOrders'])->name('office.recent.orders');

    // API Routes
    Route::get('api/tables', [OrderController::class, 'getTables']);
    Route::get('api/offices', [OrderController::class, 'getOffices']);
    Route::get('api/customers', [OrderController::class, 'getCustomers']);
    Route::get('api/products/search/{id}', [OrderController::class, 'getProducts']);
    Route::get('api/products/by-restaurant/{id}', [OrderController::class, 'getProductsByRestaurant']);
    Route::post('/api/customers/store', [OrderController::class, 'storeCustomer']);
    Route::get('api/products/{id}', [OrderController::class, 'show']);
    Route::get('/check-latest-order', [OrderController::class, 'checkLatestOrder']);


    Route::get('table/order', [RestaurentTableController::class, 'order'])->name('table.order');

    Route::post('/reception/serve/{id}', [ReceptionController::class, 'markServed']);
    Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
    Route::post('/kitchen/start/{order}', [KitchenController::class, 'start'])->name('kitchen.start');
    Route::post('/kitchen/start/{order}', [KitchenController::class, 'preparing'])->name('kitchen.start.cooking');
    Route::post('/kitchen/served/{id}', [KitchenController::class, 'markServed'])->name('kitchen.markServed');

    Route::post('/orders/update-payment', [OrderController::class, 'updatePayment'])->name('orders.updatePayment');
    Route::post('/orders/{id}/kitchen', [OrderController::class, 'moveToKitchen'])
        ->name('orders.moveToKitchen');
    Route::get('/duecustomers', [DueOrderController::class, 'index'])->name('duecustomers');
    Route::post('/reception/restaurent/due/pay/{id}', [OrderController::class, 'payDue'])->name('due.pay');
    Route::post('/customers/pay-due', [CustomerController::class, 'payDue'])
     ->name('customers.payDue');
Route::delete('payments/{id}', [PaymentController::class, 'destroy'])
    ->name('payments.destroy');

        // ->name('customers.payDue');

    // for popup order

    Route::post('/accept-order/{id}', [OrderController::class, 'acceptOrder']);
    Route::post('/reject-order/{id}', [OrderController::class, 'rejectOrder']);

    Route::get('/check-notification', [OrderController::class, 'check']);
    Route::post('/reset-notification', [OrderController::class, 'reset']);

    Route::get('/notify/{table_number}', [OrderController::class, 'setNotification']);
    Route::post('/reset-single-notification', [OrderController::class, 'resetSingleNotification']);

    // check kitchen order notification
    Route::get('/check-kitchen', [KitchenController::class, 'checkKitchen'])->name('check.kitchen');
    Route::post('/orders/serve/{id}', [KitchenController::class, 'serveOrdertocustomer'])->name('orders.serve');
});
