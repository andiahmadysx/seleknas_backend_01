<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('v1/auth/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('v1/auth/logout', [\App\Http\Controllers\AuthController::class, 'logout']);


Route::post('v1/validation', [\App\Http\Controllers\ValidationController::class, 'store'])->middleware('auth.id_card');
Route::get('v1/validations', [\App\Http\Controllers\ValidationController::class, 'index'])->middleware('auth.id_card');

Route::resource('v1/job_vacancies', \App\Http\Controllers\JobVacancyController::class )->parameters(['job_vacancies' => 'id'])->middleware('auth.id_card');
Route::resource('/v1/applications', \App\Http\Controllers\ApplyJobController::class)->middleware('auth.id_card');
