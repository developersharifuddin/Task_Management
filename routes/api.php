<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\api\BrandController;
use App\Http\Controllers\Admin\api\CategoryController;

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

// php artisan make:controller BrandController --resource --model=Brand --request=StoreBrandRequest

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// In routes/api.php
// Route::middleware('api')->group(function () {
//     Route::apiResource('brands', BrandController::class);
//     Route::apiResource('categories', CategoryController::class);
// });

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/', function () {
        $testdata = "WellCome, " . auth()->user()->name . ", Connect to API";
        return response()->json(['info' => $testdata,]);
    })->name('brand');

    Route::apiResource('brands', BrandController::class);
    Route::apiResource('categories', CategoryController::class);
});
// // 