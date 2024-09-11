<?php

use App\Http\Controllers\Api\accountTypeController;
use App\Http\Controllers\Api\subjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('accountTypes', AccountTypeController::class);
Route::apiResource('subject', SubjectController::class);
