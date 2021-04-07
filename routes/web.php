<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
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

Route::get('myaccount/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('myaccount/profile', [ProfileController::class, 'logout'])->name('profile.logout');
