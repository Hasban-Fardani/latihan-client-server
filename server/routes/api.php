<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
    
    Route::get('sparepart/list', [SparepartController::class, 'index']);
    Route::get('sparepart/{sparepart}', [SparepartController::class, 'show']);
    
    Route::get('transaction/invoice/{transaction}', [DashboardAdminController::class, 'exportPdf'])
        ->name('exportPDF');
        
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/me', [AuthController::class, 'me']);
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::apiResource('category', CategoryController::class);
        Route::apiResource('sparepart', SparepartController::class)
            ->except(['index', 'show']);
        Route::apiResource('transaction', TransactionController::class)
            ->except(['update']);
        Route::apiResource('transaction.detail', TransactionDetailController::class);
        Route::apiResource('cart', CartController::class);

        Route::middleware('ability:admin')->group(function () {
            Route::get('admin/category-analytics', [DashboardAdminController::class, 'categoriesAnalytics']);
            Route::get('admin/transaction-analytics', [DashboardAdminController::class, 'transactionAnalytics']);
            Route::get('customers', [CustomerController::class, 'index']);
            Route::apiResource('users', UserController::class);
        });
    });
});