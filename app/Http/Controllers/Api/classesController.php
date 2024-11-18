<?php

namespace App\Http\Controllers\Api;

use App\Models\classes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\student;

class classesController extends Controller
{
    public function setNewFunction(Request $request){
        $termsID = $request->terms_id;
        $studentID = $this->getStudentId($request);
        $lessonID = $request->lesson_id;

        $classes = classes::create([
            'terms_id' => $termsID,
            'student_id' => $studentID,
            'lesson_id' => $lessonID,
            'confirmed' => false,
        ]);
        return response()->json($classes);
    }
    public function getStudentClasses(Request $request){
        $startDate = $request['start_date'];
        $endDate = $request['end_date'];
        $studentID = $this->getStudentId($request);
    }




    private function getStudentId(Request $request){
        $user = $request->user();
        $user = $user->load('student');
        $user = $user->student;
        return $user['id'];
    }
}
