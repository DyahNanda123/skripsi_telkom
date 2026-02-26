<?php

use Illuminate\Support\Facades\Route;

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
        'title' => 'Selamat Datang',
        'list'  => ['Home', 'Dashboard']
    ];

    // 2. Kita kirimkan data activeMenu DAN breadcrumb ke halaman web
    return view('welcome', [
        'activeMenu' => 'dashboard',
        'breadcrumb' => $breadcrumb
    ]);
});