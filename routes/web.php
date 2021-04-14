<?php

use App\Http\Controllers\AdminCaptchaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CodeRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GetCodeController;
use App\Http\Controllers\ReceiptController;
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

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::post('/', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'show'])->name('auth.show');
Route::post('/register', [AuthController::class, 'store'])->name('auth.store');


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');


    /*
    |-------------------------------------------------
    | Routes for User
    |-------------------------------------------------
    */
    Route::middleware(['role.user'])->group(function () {
        Route::get('/myaccount/profile', [ProfileController::class, 'index'])->name('profile.index');

        Route::get('/getcode/myvalidcodes', [GetCodeController::class, 'index'])->name('getcode.index');
        Route::get('/getcode/requestcode', [GetCodeController::class, 'create'])->name('getcode.create');
        Route::post('/getcode/requestcode', [GetCodeController::class, 'store'])->name('getcode.store');

        Route::get('/waystoearn/captcha', [UserCaptchaController::class, 'create'])->name('usercaptcha.create');
        Route::post('/waystoearn/captcha', [UserCaptchaController::class, 'store'])->name('usercaptcha.store');

        Route::get('/waystoearn/uploadreceipt', [ReceiptController::class, 'edit'])->name('receipt.edit');
        Route::put('/waystoearn/uploadreceipt', [ReceiptController::class, 'update'])->name('receipt.update');
    });


    /*
    |-------------------------------------------------
    | Routes for Admin
    |-------------------------------------------------
    */
    Route::middleware(['role.admin'])->group(function () {
        Route::get('/admin/coderequests', [CodeRequestController::class, 'index'])->name('coderequest.index');
        Route::post('/admin/coderequests', [CodeRequestController::class, 'accept'])->name('coderequest.accept');
        Route::delete('/admin/coderequests', [CodeRequestController::class, 'decline'])->name('coderequest.decline');

        Route::get('/admin/add/captcha', [AdminCaptchaController::class, 'create'])->name('admincaptcha.create');
        Route::post('/admin/add/captcha', [AdminCaptchaController::class, 'store'])->name('admincaptcha.store');
    });
});
