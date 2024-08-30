<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\CusController;
use App\Http\Controllers\frontend\AssetController;
use App\Http\Controllers\frontend\TreasController;
use App\Http\Controllers\frontend\TagsController;
use App\Http\Controllers\frontend\AuditController;

use App\Services\LineMessagingService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    // return view('auth/login');
    return redirect('login');
});

/* A middleware that is checking if the user is logged in and verified. */
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    // Route::get('/send-message', function () {
    //     $userId = '<USER_ID>'; // LINE User ID ที่คุณต้องการส่งข้อความถึง
    //     $message = 'Hello, this is a test message from Laravel!';

    //     $lineService = new LineMessagingService();
    //     $success = $lineService->pushMessage($userId, $message);

    //     if ($success) {
    //         return "Message sent successfully!";
    //     } else {
    //         return "Failed to send message.";
    //     }
    // });

    // Route::get('/auth-lock-screen', function () {
    //     session()->forget('url.intended');
    //     session()->put('url.intended', url()->previous());

    //     return view('components.auth-lock-screen');
    // });


    Route::post('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');
    Route::post('/unlock_screen', [App\Http\Controllers\SearchController::class, 'unlock_screen'])->name('unlock_screen');
    Route::resource('home', App\Http\Controllers\HomeController::class);
    Route::resource('constants', App\Http\Controllers\ConstantController::class);
    Route::resource('dataStatic', App\Http\Controllers\DataStaticController::class);
    Route::resource('permission', App\Http\Controllers\PermissionController::class);
    Route::resource('CarRate', App\Http\Controllers\frontend\CarRateController::class);
    Route::resource('MotoRate', App\Http\Controllers\frontend\MotoRateController::class);

    Route::middleware(['auth', 'config.Frontends'])->group(function () {
        Route::resource('cus', CusController::class);
        Route::post('/cus/SearchData', [CusController::class, 'SearchData'])->name('cus.SearchData');
        Route::resource('tags', TagsController::class);
        Route::resource('asset', AssetController::class);
        Route::post('/asset/SearchData', [AssetController::class, 'SearchData'])->name('asset.SearchData');
        Route::resource('contract', App\Http\Controllers\frontend\ConController::class);
        Route::resource('audit', AuditController::class);
        Route::resource('treas', TreasController::class);
        Route::resource('view', App\Http\Controllers\frontend\ViewController::class);
        Route::resource('report', App\Http\Controllers\frontend\ReportController::class);
        Route::resource('ControlCenter', App\Http\Controllers\frontend\CenterController::class);
        Route::post('/ControlCenter/SearchData', [App\Http\Controllers\frontend\CenterController::class, 'SearchData'])->name('ControlCenter.SearchData');
        Route::post('/ControlCenter/SearchDataExtra', [App\Http\Controllers\frontend\CenterController::class, 'SearchDataExtra'])->name('ControlCenter.SearchDataExtra');
    });

    Route::middleware(['auth', 'config.Backends'])->group(function () {
        Route::resource('account', App\Http\Controllers\backend\AccountController::class);
        Route::resource('datatrack', App\Http\Controllers\backend\DataTrackInside::class);
        Route::resource('contracts', App\Http\Controllers\backend\ContractController::class);
        Route::resource('payments', App\Http\Controllers\backend\PaymentsController::class);
        Route::resource('view-backend', App\Http\Controllers\backend\ViewController::class);
        Route::resource('report-backend', App\Http\Controllers\backend\ReportController::class);
        Route::resource('center', App\Http\Controllers\backend\CenterController::class);
        Route::resource('spast', App\Http\Controllers\backend\SpashDueController::class);
        Route::resource('import', App\Http\Controllers\backend\ImportController::class);
        Route::resource('letter', App\Http\Controllers\backend\LetterController::class);
        Route::resource('tax', App\Http\Controllers\backend\TaxController::class);

        Route::resource('Report', App\Http\Controllers\backend\ReportBuilderController::class);
        Route::resource('ReportAcc', App\Http\Controllers\backend\ReportAccController::class);
        Route::resource('takeDoc', App\Http\Controllers\backend\TakeDocController::class);
        Route::get('/ReportgetRole', [App\Http\Controllers\backend\ReportAccController::class, 'getRole'])->name('ReportAcc.getRole');
    });


    // Route::middleware(['role:admin|superadmin'])->group(function () {
    //     Route::get('/register', [Laravel\Fortify\Http\Controllers\RegisteredUserController::class, 'create'])->name('register');
    // });

    // Route::middleware(['CheckUserRoles:manager'])->group(function () {
    //     Route::resource('view-backend', App\Http\Controllers\backend\ViewController::class);
    //     Route::resource('home-backend', App\Http\Controllers\backend\HomeController::class);
    //     Route::resource('center', App\Http\Controllers\backend\CenterController::class);
    // });

    // Route::get('/viewtest', function () {
    //     return view('backend.content-report.viewReport');
    // })->name('viewtest');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
