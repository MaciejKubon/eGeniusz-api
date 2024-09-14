<?php

use App\Http\Controllers\Api\accountTypeController;
use App\Http\Controllers\Api\lessonController;
use App\Http\Controllers\Api\subjectController;
use App\Http\Controllers\Api\subjectLevelController;
use App\Http\Controllers\Api\userDescriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('accountTypes', AccountTypeController::class);
Route::apiResource('subject', SubjectController::class);
Route::apiResource("subjectLevel", SubjectLevelController::class);
Route::apiResource('userDescription', userDescriptionController::class);
Route::apiResource('lesson', lessonController::class);
