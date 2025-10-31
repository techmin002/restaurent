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
use Modules\Vacancy\Http\Controllers\VacancyController;

Route::group(['middleware' => 'auth'], function () {
    Route::resource('vacancies', 'VacancyController');
    Route::get('vacancies/status/{id}',[VacancyController::class,'status'])->name('vacancies.status');
});
