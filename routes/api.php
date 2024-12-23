<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\classesController;
use App\Http\Controllers\Api\lessonController;
use App\Http\Controllers\Api\studentController;
use App\Http\Controllers\Api\subjectController;
use App\Http\Controllers\Api\subjectLevelController;
use App\Http\Controllers\Api\teacherController;
use App\Http\Controllers\Api\teacherDetailController;
use App\Http\Controllers\Api\termsController;
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
Route::get('TeacherTerms/{teacher}', [termsController::class, 'showTeacherTerms']);
Route::middleware('auth:sanctum')->post('/TeacherTerms', [termsController::class, 'addTeacherTerms']);
Route::middleware('auth:sanctum')->post('/TeacherTermsGet', [termsController::class, 'getTeacherTerms']);
Route::middleware('auth:sanctum')->delete('/TeacherTerms/{terms}',[termsController::class,'deleteTeacherTerm']);
Route::post('/TeacherDetail',[teacherDetailController::class,'getTeacherDetail']);
Route::middleware('auth:sanctum')->post('/TeacharDetialTerms',[termsController::class,'getTeacherDeatilsTerms']);
Route::middleware('auth:sanctum')->post('/StudentClassesGet',[termsController::class,'getStudentClasses']);
//Route::get('/studentProfile', [studentController::class, 'userProfile']);
Route::middleware('auth:sanctum')->post('/Classes',[classesController::class,'setNewFunction']);
Route::middleware('auth:sanctum')->post('/StudentClasses',[classesController::class,'getStudentClasses']);
Route::middleware('auth:sanctum')->post('/TeacherClasses',[classesController::class,'getTeacherClasses']);
Route::middleware('auth:sanctum')->delete('/StudentClasses/{classes}',[classesController::class,'deleteClasses']);
Route::middleware('auth:sanctum')->get('/Classes/{classes}',[classesController::class,'getClasses']);
Route::middleware('auth:sanctum')->put('/Classes/{classes}',[classesController::class,'confirmClasses']);
//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->post('/teacherProfile/image',[teacherController::class,'setTeacherImage']);
Route::middleware('auth:sanctum')->get('/teacherProfile/image',[teacherController::class,'getTeacherImage']);
Route::middleware('auth:sanctum')->post('/studentProfile/image',[studentController::class,'setStudentImage']);
Route::middleware('auth:sanctum')->get('/studentProfile/image',[studentController::class,'getStudentImage']);
