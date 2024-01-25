<?php
// routes/admin.php  
use App\Http\Controllers\ImportCsv;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\Admin\SellController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\OrderShipedController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ItemInfoController;
use App\Http\Controllers\NewOrderPlacedController;
use App\Http\Controllers\Admin\HK\CategoryController;
use App\Http\Controllers\Admin\PurchaseController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // // HK-01:manage Category
    Route::resource('categories', CategoryController::class);
    Route::get('categories/{category:slug}/edit', [CategoryController::class, 'edit'])->name('categories.edits');


    Route::get('/importcsv', [ImportCsv::class, 'index']);
    Route::post('/importcsvupload', [ImportCsv::class, 'upload_csv_file'])->name('uploadcsv');

    Route::get('/order', [OrderShipedController::class, 'OrderList'])->name('order.list');
    Route::post('/order/{orderId}', [OrderShipedController::class, 'sendOrderEmail'])->name('order.status');

    // Route::resource('/products', ItemInfoController::class);
    Route::resource('products', ProductController::class);
    Route::put('/purchase/{purchaseId}', [ProductController::class, 'purchaseProduct'])->name('purchase.purchase');



    // Logout route
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::get('process', [DataController::class, 'processLargeData'])->name('data-process-start');
Route::get('/create-order', [NewOrderPlacedController::class, 'store']);
