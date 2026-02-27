<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // 1. Kita buat data breadcrumb palsu/dummy dulu agar template tidak error
    $breadcrumb = (object) [
        'title' => 'DASHBOARD',
        'list'  => ['Home', 'Dashboard']
    ];

    // 2. Kita kirimkan data activeMenu DAN breadcrumb ke halaman web
    return view('welcome', [
        'activeMenu' => 'dashboard',
        'breadcrumb' => $breadcrumb
    ]);
});

// Jalur untuk Login & Logout
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);

// Jalur untuk Edit Profil (Hanya bisa diakses kalau sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
});