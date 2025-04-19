<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
require __DIR__.'/api/auth.php';



Route::apiResource('/categories', CategoryController::class);
//Route::apiResource('/products', ProductController::class);

Route::get("/products/{id}",[ProductController::class,'show']);
Route::get("/products",[ProductController::class,'index']);

Route::post("checkout",[CheckoutController::class,'store'])->middleware('auth:sanctum');
Route::get("orders/{id}",[OrderController::class,'show'])->middleware('auth:sanctum');

Route::apiResource('/carts', CartController::class);
