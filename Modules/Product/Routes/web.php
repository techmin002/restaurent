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

use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\MachineryController;
use Modules\Product\Http\Controllers\AccessoryController;
use Modules\Product\Http\Controllers\InventoryController;
use Modules\Product\Http\Controllers\ProductBrandController;
use Modules\Product\Http\Controllers\ProductCategoryController;
use Modules\Product\Http\Controllers\TechnicalToolsController;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductController::class);
    Route::resource('products-brands', ProductBrandController::class);
    Route::get('brands/status/{id}', [ProductBrandController::class,'status'])->name('product-brand.status');
    Route::resource('products-accessories', AccessoryController::class);
    Route::get('product-accessory/status/{id}', [AccessoryController::class,'status'])->name('product-accessory.status');

    Route::resource('products-machineries', MachineryController::class);
    Route::get('product-machinery/status/{id}', [MachineryController::class,'status'])->name('product-machinery.status');

    Route::resource('products-categories', ProductCategoryController::class);
    Route::get('category/status/{id}', [ProductCategoryController::class,'status'])->name('product-category.status');
    Route::get('inventories/{type}',[InventoryController::class,'index'])->name('inventories.index');
    Route::get('inventories/create',[InventoryController::class,'create'])->name('inventories.create');

    Route::resource('technicaltools', TechnicalToolsController::class)->names('technicaltools');
    Route::get('technicaltools/status/{id}', [TechnicalToolsController::class,'status'])->name('technicaltools.status');


});

