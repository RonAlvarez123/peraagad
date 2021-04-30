<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminCaptchaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
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

Route::middleware(['alreadyLoggedIn'])->group(function () {
    Route::middleware(['throttle:login'])->group(function () {
        Route::post('/', [AuthController::class, 'login'])->name('auth.login');
    });

    Route::get('/', [AuthController::class, 'index'])->name('auth.index');

    Route::prefix('register')->group(function () {
        Route::get('/', [AuthController::class, 'create'])->name('auth.create');
        Route::post('/', [AuthController::class, 'store'])->name('auth.store');
    });
});


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');


    /*
    |-------------------------------------------------
    | Routes for User
    |-------------------------------------------------
    */
    Route::middleware(['role.user'])->group(function () {
        Route::get('/about', [AboutController::class, 'index'])->name('about.index');

        Route::prefix('myaccount/profile')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
            Route::post('/', [ProfileController::class, 'bonus'])->name('profile.bonus');
            Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
            Route::put('/picture', [ProfileController::class, 'picture'])->name('profile.picture');
        });

        Route::prefix('getcode')->group(function () {
            Route::get('/myvalidcodes', [GetCodeController::class, 'index'])->name('getcode.index');
            Route::get('/requestcode', [GetCodeController::class, 'create'])->name('getcode.create');
            Route::post('/requestcode', [GetCodeController::class, 'store'])->name('getcode.store');
        });

        Route::prefix('waystoearn')->group(function () {
            Route::get('/captcha', [UserCaptchaController::class, 'edit'])->name('usercaptcha.edit');
            Route::put('/captcha', [UserCaptchaController::class, 'update'])->name('usercaptcha.update');

            Route::get('/uploadreceipt', [ReceiptController::class, 'edit'])->name('receipt.edit');
            Route::put('/uploadreceipt', [ReceiptController::class, 'update'])->name('receipt.update');

            Route::get('/colorgame', [ColorGameController::class, 'edit'])->name('colorgame.edit');
            Route::post('/colorgame', [ColorGameController::class, 'claim'])->name('colorgame.claim');
            Route::put('/colorgame', [ColorGameController::class, 'update'])->name('colorgame.update');
        });

        Route::prefix('cashout')->group(function () {
            Route::post('/', [CashoutRequestController::class, 'redirect'])->name('cashoutrequest.redirect');

            Route::get('/gcash', [GcashController::class, 'create'])->name('gcash.create');
            Route::get('/bank', [BankController::class, 'create'])->name('bank.create');
            Route::get('/remit', [RemitController::class, 'create'])->name('remit.create');

            Route::middleware(['throttle:cashout'])->group(function () {
                Route::post('/gcash', [GcashController::class, 'store'])->name('gcash.store');
                Route::post('/bank', [BankController::class, 'store'])->name('bank.store');
                Route::post('/remit', [RemitController::class, 'store'])->name('remit.store');
            });
        });
    });


    /*
    |-------------------------------------------------
    | Routes for Admin
    |-------------------------------------------------
    */
    Route::middleware(['role.admin'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::prefix('coderequests')->group(function () {
                Route::get('/', [CodeRequestController::class, 'index'])->name('coderequest.index');
                Route::get('/{codeRequest}', [CodeRequestController::class, 'show'])->name('coderequest.show');

                Route::middleware(['throttle:adminCodeRequest'])->group(function () {
                    Route::post('/{codeRequest}', [CodeRequestController::class, 'store'])->name('coderequest.store');
                    Route::delete('/{codeRequest}', [CodeRequestController::class, 'destroy'])->name('coderequest.destroy');
                });
            });

            Route::prefix('cashoutrequests')->group(function () {
                Route::get('/', [CashoutRequestController::class, 'index'])->name('cashoutrequest.index');
                Route::get('/{cashoutRequest}', [CashoutRequestController::class, 'show'])->name('cashoutrequest.show');

                Route::middleware(['throttle:adminCashoutRequest'])->group(function () {
                    Route::put('/{cashoutRequest}', [CashoutRequestController::class, 'update'])->name('cashoutrequest.update');
                    Route::delete('/{cashoutRequest}', [CashoutRequestController::class, 'destroy'])->name('cashoutrequest.destroy');
                });
            });

            Route::get('/add/captcha', [AdminCaptchaController::class, 'create'])->name('admincaptcha.create');
            Route::post('/add/captcha', [AdminCaptchaController::class, 'store'])->name('admincaptcha.store');
        });
    });
});
