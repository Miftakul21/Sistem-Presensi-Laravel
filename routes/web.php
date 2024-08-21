<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\RekapPresensiController;
use App\Http\Controllers\KetidakhadiranController;


Route::get('/', [AuthController::class, 'index']);

Route::post('/auth-login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/karyawan', [UserController::class, 'index']);
Route::post('/karyawan', [UserController::class, 'insert']);
Route::post('/karyawan-delete', [UserController::class, 'delete']);
Route::post('/karyawan-update', [UserController::class, 'update']);

Route::get('/divisi', [DivisiController::class, 'index']);
Route::post('/divisi', [DivisiController::class, 'insert']);
Route::post('/divisi-delete', [DivisiController::class, 'delete']);
Route::post('/divisi-update', [DivisiController::class, 'update']);

Route::get('/location', [LocationController::class, 'index']);
Route::post('/location', [LocationController::class, 'insert']);
Route::post('/location-delete', [LocationController::class, 'delete']);
Route::post('/locaion-update', [LocationController::class, 'update']);

Route::get('/presensi', [PresensiController::class, 'index']);
Route::get('/get-location-office', [PresensiController::class, 'getLocation']);
Route::post('/presensi-masuk', [PresensiController::class, 'presensiMasuk']);
Route::post('/presensi-keluar', [PresensiController::class, 'presensiKeluar']);

Route::get('/rekap-harian', [RekapPresensiController::class, 'index']);
Route::get('/rekap-bulanan', [RekapPresensiController::class, 'rekapBulanan']);
Route::get('/rekap-laporan-harian', [RekapPresensiController::class, 'exportLaporanHarian']);
Route::get('/rekap-laporan-bulanan', [RekapPresensiController::class, 'exportLaporanHarian']);

Route::get('/ketidakhadiran', [KetidakhadiranController::class, 'index']);
Route::post('/ketidakhadiran', [KetidakhadiranController::class, 'insert']);
Route::post('/ketidakhadiran-update', [KetidakhadiranController::class, 'update']);
Route::post('/ketidakhadiran-delete', [KetidakhadiranController::class, 'delete']);

Route::get('/data-ketidakhadiran', [KetidakhadiranController::class, 'getDataKetidakhadiran']);
Route::post('/status-ketidakhadiran', [KetidakhadiranController::class, 'statusKetidakhadiran']);

Route::get('/profile', [UserController::class, 'profile']);