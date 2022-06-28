<?php

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
Route::apiResource('brand', 'App\Http\Controllers\BrandController');
Route::apiResource('car', 'App\Http\Controllers\CarController');
Route::apiResource('client', 'App\Http\Controllers\ClientController');
Route::apiResource('location', 'App\Http\Controllers\LocationController');
Route::apiResource('model', 'App\Http\Controllers\ModelController');
