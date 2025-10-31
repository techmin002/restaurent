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
use Modules\Testimonial\Http\Controllers\TestimonialController;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('testimonials', 'TestimonialController');
    Route::get('testimonial/status/{id}',[TestimonialController::class,'status'])->name('testimonial.status');
});
