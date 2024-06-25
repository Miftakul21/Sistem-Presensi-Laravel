<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\LocationController;


Route::get('/', [AuthController::class, 'index']);

Route::post('/auth-login', [AuthController::class, 'login']);

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/divisi', [DivisiController::class, 'index']);
Route::post('/divisi', [DivisiController::class, 'insert']);
Route::post('/divisi-delete', [DivisiController::class, 'delete']);
Route::post('/divisi-update', [DivisiController::class, 'update']);

Route::get('/location', [LocationController::class, 'index']);
Route::post('/location', [LocationController::class, 'insert']);
Route::post('/location-delete', [LocationController::class, 'delete']);
Route::post('/locaion-update', [LocationController::class, 'update']);