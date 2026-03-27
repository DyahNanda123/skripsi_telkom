<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalonPelangganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

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

// --- Fitur Data Pengguna ---
    Route::group(['prefix' => 'pengguna'], function () {
        Route::get('/', [UserController::class, 'index']);          // Menampilkan halaman awal
        Route::post('/list', [UserController::class, 'list']);      // Mengambil data untuk tabel (AJAX)
        Route::get('/create_ajax', [UserController::class, 'create_ajax']); // menambah data baru
        Route::post('/ajax', [UserController::class, 'store_ajax']); // menyimpan data baru
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // untuk mengedit 
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // untuk menyimpan editannya
        Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']); // detail
        Route::get('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);  // Menampilkan modal konfirmasi
        Route::delete('/{id}/destroy_ajax', [UserController::class, 'destroy_ajax']); // Memproses penghapusan
        Route::get('/import', [UserController::class, 'import']);
        Route::post('/import_ajax', [UserController::class, 'import_ajax']);
        Route::get('/export_excel', [UserController::class, 'export_excel']);
        Route::get('/export_pdf', [UserController::class, 'export_pdf']);
    });

    // --- Fitur Calon Pelanggan ---
    Route::group(['prefix' => 'calon_pelanggan'], function () {
        Route::get('/', [CalonPelangganController::class, 'index']);          // Menampilkan halaman awal
        Route::post('/list', [CalonPelangganController::class, 'list']);      // Mengambil data untuk tabel (AJAX)
        Route::get('/create_ajax', [CalonPelangganController::class, 'create_ajax']); // menambah data baru
        Route::post('/store_ajax', [CalonPelangganController::class, 'store_ajax']); // menyimpan data baru
        Route::get('/{id}/edit_ajax', [CalonPelangganController::class, 'edit_ajax']); // untuk mengedit 
        Route::put('/{id}/update_ajax', [CalonPelangganController::class, 'update_ajax']); // untuk menyimpan editannya
        Route::get('/{id}/show_ajax', [CalonPelangganController::class, 'show_ajax']); // detail
        Route::get('/{id}/delete_ajax', [CalonPelangganController::class, 'delete_ajax']);  // Menampilkan modal konfirmasi
        Route::delete('/{id}/destroy_ajax', [CalonPelangganController::class, 'destroy_ajax']); // Memproses penghapusan
        Route::get('/import', [CalonPelangganController::class, 'import']);
        Route::post('/import_ajax', [CalonPelangganController::class, 'import_ajax']);
        Route::get('/export_excel', [CalonPelangganController::class, 'export_excel']);
        Route::get('/export_pdf', [CalonPelangganController::class, 'export_pdf']);
    });
    