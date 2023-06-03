<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\SearchController;

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
    return view('welcome');
});

Route::resource('mahasiswa', MahasiswaController::class);

Route::get('/search', [SearchController::class, 'search']);

Route::get('mahasiswa/{mahasiswa}/khs', [MahasiswaController::class, 'khs'])->name('mahasiswa.khs');
Route::get('mahasiswa/{mahasiswa}/cetak_khs', [MahasiswaController::class, 'cetak_khs'])->name('mahasiswa.cetak_khs');

