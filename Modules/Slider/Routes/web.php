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
use Modules\Slider\Http\Controllers\SliderController;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('sliders', 'SliderController');
    Route::get('sliders/status/{id}',[SliderController::class,'status'])->name('slider.status');
});
