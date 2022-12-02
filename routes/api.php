<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Admin\MotorController;
use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Controllers\Api\User\MotorController as UserMotorController;
use App\Http\Controllers\Api\User\RentMotorController;
use App\Http\Controllers\Api\User\MyOrderController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('admin')->group(function () {
        Route::resource('motor', MotorController::class);
        Route::resource('transaksi', TransactionController::class);
    });

    Route::get('orderan-saya', [MyOrderController::class, 'index']);
    Route::post('pembayaran', [MyOrderController::class, 'processPaymentRent']);
    Route::post('rental-motor/{motor:slug}', [RentMotorController::class, 'store']);

    Route::post('/logout', [AuthController::class, 'logout']);
}); 

Route::get('motor', [UserMotorController::class, 'index']);
Route::get('motor/{motor:slug}', [UserMotorController::class, 'show']);
