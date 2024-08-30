<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AccountController;
use App\Http\Controllers\api\LoansController;
use App\Http\Controllers\Api\LockerController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// route::get('login', function () {
//     return response()->json([
//         'message' => 'Please login'
//     ], 401);
// })->name('login');

// route::post('login', [\App\Http\Controllers\api\AccountController::class, 'login'])->name('login');

route::post('auth/getR2', [AccountController::class, 'GetReference2']);
route::post('account/verify', [AccountController::class, 'accountverify']);
route::post('account/loginuser', [AccountController::class, 'loginuser']);
route::post('account/token/setting', [AccountController::class, 'updateToken']);

route::post('account/getCredocode', [AccountController::class, 'getCredocode']);
route::post('account/updateCredo', [AccountController::class, 'updateCredo']);

route::post('leasing/account', [LoansController::class, 'LeasingAccount']);
route::post('leasing/account/invoice', [LoansController::class, 'InvoiceHistory']);
route::post('leasing/account/invoiceDetail', [LoansController::class, 'InvoiceDetail']);
route::post('leasing/account/receipt', [LoansController::class, 'ReceiptHistory']);
route::post('leasing/account/receiptDetail', [LoansController::class, 'ReceiptDetail']);
route::post('leasing/account/paymentDetail', [LoansController::class, 'PaymentDetail']);

// locker
route::get('locker/getBranch', [LockerController::class, 'getBranch']);


// route::post('account/otp/request', [AccountController::class, 'requestOTP']);
// route::post('account/otp/verify', [AccountController::class, 'verifyUserWithOTP']);

route::group(['middleware' => 'auth:sanctum'], function () {
    // route::get('numbers', function () {
    //     return response()->json([
    //         'numbers' => rand(1, 100)
    //     ]);
    // });
    // route::get('account', [\App\Http\Controllers\api\AccountController::class, 'numbers']);
    // route::apiResource('accounts', \App\Http\Controllers\api\AccountController::class);
});
