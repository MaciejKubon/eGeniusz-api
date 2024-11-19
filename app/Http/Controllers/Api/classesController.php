<?php

namespace App\Http\Controllers\Api;

use App\Models\classes;
use App\Http\Controllers\Controller;
use App\Models\lesson;
use App\Models\terms;
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
        $studentID = $this->getStudentId($request);
        $student = student::find($studentID);
        $classes = $student->classes()->get();
        $sDate = new \DateTime($startDate);
        $classesArr= [];
        foreach ($classes as $class){
            $add = false;
            $term = $class->terms()->get();
            foreach ($term as $t){
                $sD = new \DateTime($t->start_date);
                if($sD->format('Y-m-d')==$sDate->format('Y-m-d')){
                    $add = true;
                }
            }
            if($add==true)
            {
                $classesArr[] =[
                    'id' => $class->id,
                    'confirmed' => $class->confirmed,
                    'lesson'=>$this->getLesson($class->lesson_id),
                    'term'=>$this->getTerm($class->terms_id),
                ];
            }
        }
        return response()->json($classesArr);
    }




    private function getStudentId(Request $request){
        $user = $request->user();
        $user = $user->load('student');
        $user = $user->student;
        return $user['id'];
    }
    private function getLesson($id){
        $lesson = lesson::find($id);
        $lesson = $lesson->load('subject','subjectLevel');
        $subject = $lesson->subject;
        $level = $lesson->subjectLevel;

        return ([
            'id'=> $lesson->id,
            'subject' => $subject,
            'subjcet_level' => $level,
            'price' => $lesson->price,
        ]);
    }

    private function getTerm($id){
        $term = terms::find($id);
        return ([
            'id' => $term->id,
            'teacher_id' => $term->teacher_id,
            'start_date' => $term->start_date,
            'end_date' => $term->end_date,
        ]);
    }
}
