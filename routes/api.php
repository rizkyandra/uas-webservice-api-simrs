<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('pasien', 'PasienController');
Route::resource('poliklinik', 'PoliklinikController');
Route::resource('dokter', 'DokterController');
Route::resource('jadwal-dokter', 'JadwalDokterController');
Route::resource('registrasi', 'RegistrasiController');
