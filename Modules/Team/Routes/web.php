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
use Modules\Team\Http\Controllers\TeamController;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('teams', 'TeamController');
    Route::get('team/status/{id}',[TeamController::class,'status'])->name('team.status');
});
