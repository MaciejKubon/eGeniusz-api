<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\lessonController;
use App\Http\Controllers\Api\studentController;
use App\Http\Controllers\Api\subjectController;
use App\Http\Controllers\Api\subjectLevelController;
use App\Http\Controllers\Api\teacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/studentProfile', [studentController::class, 'showProfile']);
Route::middleware('auth:sanctum')->put('/studentProfile', [studentController::class, 'updateProfile']);
Route::middleware('auth:sanctum')->get('/teacherProfile', [teacherController::class, 'showProfile']);
Route::middleware('auth:sanctum')->put('/teacherProfile', [teacherController::class, 'updateProfile']);
Route::apiResource('/subject', SubjectController::class);
Route::apiResource('/subjectLevel', SubjectLevelController::class);
Route::middleware('auth:sanctum')->get('/TeacherLesson',[lessonController::class,'showTeacher']);
Route::middleware('auth:sanctum')->post('/TeacherLesson',[lessonController::class,'addLesson']);
Route::middleware('auth:sanctum')->put('/TeacherLesson/{lesson}',[lessonController::class,'editLesson']);
Route::middleware('auth:sanctum')->delete('/TeacherLesson/{lesson}',[lessonController::class,'deleteLesson']);
Route::post('/Teachers',[lessonController::class,'getTeachersLesson']);
//Route::get('/studentProfile', [studentController::class, 'userProfile']);

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
