<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminCaptchaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CashoutController;
use App\Http\Controllers\CashoutRequestController;
use App\Http\Controllers\CodeRequestController;
use App\Http\Controllers\ColorGameController;
use App\Http\Controllers\GcashController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GetCodeController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\RemitController;
use App\Http\Controllers\UserCaptchaController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['throttle:login'])->group(function () {
    Route::post('/', [AuthController::class, 'login'])->name('auth.login');
});

Route::get('/', [AuthController::class, 'index'])->name('auth.index');

Route::get('/register', [AuthController::class, 'create'])->name('auth.create');
Route::post('/register', [AuthController::class, 'store'])->name('auth.store');


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');


    /*
    |-------------------------------------------------
    | Routes for User
    |-------------------------------------------------
    */
    Route::middleware(['role.user'])->group(function () {
        Route::get('/about', [AboutController::class, 'index'])->name('about.index');

        Route::get('/myaccount/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/myaccount/profile', [ProfileController::class, 'bonus'])->name('profile.bonus');
        Route::put('/myaccount/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/getcode/myvalidcodes', [GetCodeController::class, 'index'])->name('getcode.index');
        Route::get('/getcode/requestcode', [GetCodeController::class, 'create'])->name('getcode.create');
        Route::post('/getcode/requestcode', [GetCodeController::class, 'store'])->name('getcode.store');

        Route::get('/waystoearn/captcha', [UserCaptchaController::class, 'edit'])->name('usercaptcha.edit');
        Route::put('/waystoearn/captcha', [UserCaptchaController::class, 'update'])->name('usercaptcha.update');

        Route::get('/waystoearn/uploadreceipt', [ReceiptController::class, 'edit'])->name('receipt.edit');
        Route::put('/waystoearn/uploadreceipt', [ReceiptController::class, 'update'])->name('receipt.update');

        Route::get('/waystoearn/colorgame', [ColorGameController::class, 'edit'])->name('colorgame.edit');
        Route::post('/waystoearn/colorgame', [ColorGameController::class, 'claim'])->name('colorgame.claim');
        Route::put('/waystoearn/colorgame', [ColorGameController::class, 'update'])->name('colorgame.update');

        Route::post('/cashout', [CashoutRequestController::class, 'redirect'])->name('cashoutrequest.redirect');

        Route::get('/cashout/gcash', [GcashController::class, 'create'])->name('gcash.create');
        Route::post('/cashout/gcash', [GcashController::class, 'store'])->name('gcash.store');

        Route::get('/cashout/bank', [BankController::class, 'create'])->name('bank.create');
        Route::post('/cashout/bank', [BankController::class, 'store'])->name('bank.store');

        Route::get('/cashout/remit', [RemitController::class, 'create'])->name('remit.create');
        Route::post('/cashout/remit', [RemitController::class, 'store'])->name('remit.store');
    });


    /*
    |-------------------------------------------------
    | Routes for Admin
    |-------------------------------------------------
    */
    Route::middleware(['role.admin'])->group(function () {
        Route::get('/admin/coderequests', [CodeRequestController::class, 'index'])->name('coderequest.index');
        Route::get('/admin/coderequests/{codeRequest}', [CodeRequestController::class, 'show'])->name('coderequest.show');
        Route::post('/admin/coderequests', [CodeRequestController::class, 'store'])->name('coderequest.store');
        Route::delete('/admin/coderequests', [CodeRequestController::class, 'destroy'])->name('coderequest.destroy');

        Route::get('/admin/cashoutrequests', [CashoutRequestController::class, 'index'])->name('cashoutrequest.index');
        Route::get('/admin/cashoutrequests/{cashoutRequest}', [CashoutRequestController::class, 'show'])->name('cashoutrequest.show');

        Route::get('/admin/add/captcha', [AdminCaptchaController::class, 'create'])->name('admincaptcha.create');
        Route::post('/admin/add/captcha', [AdminCaptchaController::class, 'store'])->name('admincaptcha.store');
    });
});
