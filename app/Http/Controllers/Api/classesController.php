<?php

namespace App\Http\Controllers\Api;

use App\Models\classes;
use App\Http\Controllers\Controller;
use App\Models\lesson;
use App\Models\teacher;
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
    public function deleteClasses(Classes $classes){
        $classes->delete();
        return response()->json($classes);
    }

    public function getClasses(Classes $classes){

        $term = terms::find($classes->terms_id);
        $lesson = $this->getLesson($classes->lesson_id);
        $student = $this->getStudent($classes->student_id);
        return response()->json([
            'id'=>$classes->id,
            'confirmed'=>$classes->confirmed,
            'terms'=>$term,
            'lesson'=>$lesson,
            'student'=>$student,
        ]);
    }
    public function confirmClasses(Request $request,Classes $classes){
        $classes ->update(['confirmed'=>$request->confirmed]);
        return response()->json($classes);
    }
    public function getStudentClasses(Request $request){
        $startDate = $request['start_date'];
        $endDate = $request['end_date'];
        $confirmed = $request['confirmed'];
        $student = student::find($this->getStudentId($request));
        $Studentclasses = $student->load('classes')->classes;
        $sDate = new \DateTime($startDate);
        $eDate= new \DateTime($endDate);
        $secDate =new \DateTime($startDate);
        $classesArr= [];
        while($sDate<=$eDate) {
            $secDate = $secDate->modify('+1 day');
            foreach ($Studentclasses as $class){
                if($confirmed == $class->confirmed)
                {
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
                            'date' => $sDate->format('Y-m-d'),
                            'confirmed' => $class->confirmed,
                            'lesson'=>$this->getLesson($class->lesson_id),
                            'term'=>$this->getTerm($class->terms_id),
                        ];
                    }
                }

            }
            $sDate->modify('+1 day');
        }
        return response()->json($classesArr);
    }
    public function getTeacherClasses(Request $request){
        $startDate = $request['start_date'];
        $endDate = $request['end_date'];
        $confirmed = $request['confirmed'];
        $teacher = teacher::find($this->getTeacherId($request));
        $teacherTerms = $teacher->load('terms')->terms;
        $teacherClasses = $teacherTerms->load('classes');
        $sDate = new \DateTime($startDate);
        $eDate= new \DateTime($endDate);
        $classesArr= [];
        foreach ($teacherClasses as $class){
            if($sDate<= new \DateTime($class->start_date)
                && $eDate>= new \DateTime($class->end_date)
                && $class->classes != null){
                $techClass = $class->load('classes')->classes;
                if($techClass->confirmed==$confirmed){
                    $classesArr[] = [
                        'id' => $class->id,
                        'start_date' => $class->start_date,
                        'end_date' => $class->end_date,
                        'classes' => [
                            'id' => $class->classes->id,
                            'student'=> $this->getStudent($techClass->student_id),
                            'lesson'=>$this->getLesson($techClass->lesson_id),
                            'confirmed' => $techClass->confirmed,
                        ],

                    ];
                }
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
    private function getStudent($id)
    {
        $student = student::find($id);
        return ([
            'id' => $student->id,
            'firstName' => $student->firstName,
            'lastName' => $student->lastName,
        ]);
    }
    public function getTeacher($id){
        $teacher = teacher::find($id);
        return ([
            'id' => $teacher->id,
            'firstName' => $teacher->firstName,
            'lastName' => $teacher->lastName,
        ]);
    }
    private function getLesson($id){
        $lesson = lesson::find($id);
        $lesson = $lesson->load('subject','subjectLevel');
        $subject = $lesson->subject;
        $level = $lesson->subjectLevel;

        return ([
            'id'=> $lesson->id,
            'subject' => $subject,
            'subject_level' => $level,
            'price' => $lesson->price,
        ]);
    }

    private function getTerm($id){
        $term = terms::find($id);
        return ([
            'id' => $term->id,
            'teacher' => $this->getTeacher($term->teacher_id),
            'start_date' => $term->start_date,
            'end_date' => $term->end_date,
        ]);
    }
    private function getTeacherId(Request $request){
        $user = $request->user();
        $user = $user->load('teacher');
        $user = $user->teacher;
        return $user['id'];
    }
}
