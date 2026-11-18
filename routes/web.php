<?php

use App\Http\Controllers\AksesiBenihController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelompokTanamanController;
use App\Http\Controllers\PerlakuanPenyimpananController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');

// Data utama
Route::resource('aksesi', AksesiBenihController::class)
    ->parameters(['aksesi' => 'aksesi']);

// Kategori
Route::resource('kelompok-tanaman', KelompokTanamanController::class)
    ->parameters(['kelompok-tanaman' => 'kelompok'])
    ->except('show');

// Pilihan jamak (master perlakuan)
Route::resource('perlakuan', PerlakuanPenyimpananController::class)
    ->parameters(['perlakuan' => 'perlakuan'])
    ->except('show');
