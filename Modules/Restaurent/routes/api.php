<?php

use Illuminate\Support\Facades\Route;
use Modules\Restaurent\Http\Controllers\RestaurentController;
// use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('restaurents', RestaurentController::class)->names('restaurent');
});

Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'This is a public test API!',
        'data' => [
            ['id' => 1, 'name' => 'Sugam'],
            ['id' => 2, 'name' => 'Ram'],
            ['id' => 3, 'name' => 'Shyam']
        ]
    ]);
});
