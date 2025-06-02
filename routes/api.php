<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\GuruController;
use App\Http\Controllers\API\IndustriController;
use App\Http\Controllers\API\PklController;
use App\Http\Controllers\API\SiswaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/users', [AuthController::class, 'index']);

Route::apiResource('/guru', GuruController::class);
Route::apiResource('/industri', IndustriController::class);
Route::apiResource('/pkl', PklController::class);
Route::apiResource('/siswa', SiswaController::class);

