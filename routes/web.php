<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobApplicationController;

Route::get('/', [JobApplicationController::class, 'index'])->name('index');

Route::get('/jobs/create', [JobApplicationController::class, 'create']);
Route::post('/jobs', [JobApplicationController::class, 'store']);

Route::get('/jobs/{jobApplication}', [JobApplicationController::class, 'show']);

Route::get('/jobs/{jobApplication}/edit', [JobApplicationController::class, 'edit']);
Route::put('/jobs/{jobApplication}', [JobApplicationController::class, 'update']);

Route::delete('/jobs/{jobApplication}', [JobApplicationController::class, 'destroy']);