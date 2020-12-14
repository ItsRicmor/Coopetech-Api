<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource( 'categories', CategoryController::class, ['only' => ['index', 'store', 'show', 'update', 'destroy']] );
Route::resource( 'brands', BrandsController::class, ['only' => ['index', 'store', 'show', 'update', 'destroy']] );
Route::resource( 'products', ProductController::class, ['only' => ['index', 'store', 'show', 'update', 'destroy']] );
Route::resource( 'purchases', PurchaseController::class, ['only' => ['index', 'store', 'show', 'update', 'destroy']] );
