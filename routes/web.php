<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Auth\LoginController;




// Public landing page - NO authentication required

Route::get('/',[FrontendController::class,'welcome'])->name('views.frontend.welcome');

// Authentication routes (login, register, etc.)
Auth::routes();

// Authenticated routes group - requires login
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('inquires', InquiryController::class);
});

//frontend//
Route::get('/about',[FrontendController::class,'about'])->name('frontend.about');
Route::get('/contact',[FrontendController::class,'contact'])->name('frontend.contact');
Route::post('/contact', [FrontendController::class, 'contactStore'])->name('contact.store');
Route::get('/plan',[FrontendController::class,'plan'])->name('frontend.plan');
Route::get('/blogs',[FrontendController::class,'blogs'])->name('frontend.blogss');

    Route::get('/privacy',[FrontendController::class,'privacy'])->name('frontend.privacy');
    Route::get('/terms',[FrontendController::class,'terms'])->name('frontend.terms');

    //login
    Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('frontend.login');

    // Route::get('/dashboard', [HomeController::class, 'login'])->name('login');


