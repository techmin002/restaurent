<?php

use Illuminate\Support\Facades\Route;
use Modules\Restaurent\Http\Controllers\RestaurentController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('restaurents', RestaurentController::class)->names('restaurent');
});
