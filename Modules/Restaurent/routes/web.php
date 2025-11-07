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

Route::middleware(['auth', 'verified'])->group(function () {


  // Add this route to your routes/web.php file
  Route::post('/check-customer-by-phone', [RestaurentController::class, 'checkCustomerByPhone'])->name('check.customer.by.phone');
  Route::get('/api/customers/{customerId}/recent-orders', [OrderController::class, 'getCustomerRecentOrders']);



  Route::resource('restaurents', RestaurentController::class)->names('restaurent');
  Route::resource('sections', SectionController::class)->names('sections');
  Route::resource('tables', RestaurentTableController::class)->names('tables');
  Route::resource('menus', MenuController::class)->names('menus');
  Route::resource('offices', OfficeRegisterController::class)->names('offices');
  Route::resource('customers', CustomerController::class)->names('customers');
  // Route::get('pos', [PosController::class,'index'])->name('pos.index');
  Route::get('new/order', [OrderController::class, 'create'])->name('neworders');
  Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

  Route::get('api/tables', [OrderController::class, 'getTables']);
  Route::get('api/offices', [OrderController::class, 'getOffices']);
  Route::get('api/customers', [OrderController::class, 'getCustomers']);
  Route::get('api/products/search/{id}', [OrderController::class, 'getProducts']);
  Route::get('api/products/by-restaurant/{id}', [OrderController::class, 'getProductsByRestaurant']);
  Route::post('/api/customers/store', [OrderController::class, 'storeCustomer']);
  Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
  Route::get('api/products/{id}', [OrderController::class, 'show']);
  Route::get('/check-latest-order', [OrderController::class, 'checkLatestOrder']);

  Route::get('tab/order/{id}', [RestaurentController::class, 'table_order'])->name('tab.order');
  Route::get('office/order/{id}', [RestaurentController::class, 'office_order'])->name('office.order');
  Route::post('office/orders/submit', [OrderController::class, 'office_orders_submit'])->name('office.orders.submit');
  Route::post('tables/orders/submit', [OrderController::class, 'table_orders_submit'])->name('tables.orders.submit');
});
