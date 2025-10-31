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
use Modules\Blog\Http\Controllers\BlogController;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('blogs', 'BlogController');
    Route::get('blog/status/{id}',[BlogController::class,'status'])->name('blog.status');
});

