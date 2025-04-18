<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('logout', [HomeController::class, 'proses_logout']);
Route::post('proses_login', [HomeController::class, 'cek_login']);
Route::get('', [HomeController::class, 'form_login'])->name('login');

// home
Route::get('home', [HomeController::class, 'index'])->name('index');

// menu penjualan
Route::get('list_penjualan', [HomeController::class, 'index_penjualan'])->name('daftar_penjualan');
Route::get('/add', [HomeController::class, 'form_add'])->name('form_add');
Route::post('/insert', [HomeController::class, 'simpan']);

Route::get('/edit/{id}', [HomeController::class, 'form_edit'])->name('form_edit');
Route::post('/update', [HomeController::class, 'rubah']);

Route::get('/delete/{id}', [HomeController::class, 'hapus']);

// menu admin
Route::get('register', [HomeController::class, 'form_register']);
Route::post('/insert_register', [HomeController::class, 'simpan_register']);

// menu produk
Route::get('list_produk', [HomeController::class, 'index_produk'])->name('index_produk');
Route::get('add_produk', [HomeController::class, 'form_add_produk'])->name('form_add_produk');
Route::post('insert_produk', [HomeController::class, 'simpan_produk']);
Route::get('edit_produk/{id}', [HomeController::class, 'form_edit_produk'])->name('form_edit_produk');
Route::post('update_produk', [HomeController::class, 'rubah_produk']);
Route::get('/delete_produk/{id}', [HomeController::class, 'hapus_produk']);
