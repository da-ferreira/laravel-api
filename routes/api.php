<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ModelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/*
    Cria os métodos:
    index   -> GET
    store   -> POST
    show    -> GET
    update  -> PUT|PATCH
    destroy -> DELETE
*/
Route::apiResource('brand', BrandController::class);
Route::apiResource('car', CarController::class);
Route::apiResource('client', ClientController::class);
Route::apiResource('location', LocationController::class);
Route::apiResource('model', ModelController::class);
