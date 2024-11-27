<?php

namespace App\Http\Controllers\Api;

use App\Models\lesson;
use App\Models\student;
use App\Models\teacher;
use App\Models\terms;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class termsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addTeacherTerms(Request $request){
        $request->validate([
            "start_date" => 'required|date_format:Y-m-d H:i:s',
            "end_date" => 'required|date_format:Y-m-d H:i:s|after:start_date',
        ]);
        $startDate = $request['start_date'];
        $endDate = $request['end_date'];
        $teacherId=$this->getTeacherId($request);
        $teacher = teacher::find($teacherId);
        $terms = $teacher->terms;
        foreach ($terms as $ter) {
            $sDate = $ter['start_date'];
            $eDate = $ter['end_date'];
        if(($sDate>= $startDate && $eDate<=$endDate)||
            ($sDate<=$startDate && $eDate>=$endDate)||
            ($sDate>=$startDate && $eDate<=$endDate)||
            ($sDate<=$startDate && $eDate>=$endDate)){

            return response()->json(['message' => 'Data koliduje z innym terminem'], 400);
        }}

        $term =terms::create([
            "teacher_id" => $teacherId,
            "start_date" => $startDate,
            "end_date" => $endDate ,

        ]);
        return response()->json($term);


    }
    public function showTeacherTerms(teacher $teacher){
        $terms = $teacher->terms()->get();
        return response()->json($terms);
    }
    public function getTeacherDeatilsTerms(request $request){
        $startDate = $request['start_date'];
        $endDate = $request['end_date'];
        $idTeacher = $request['teacher_id'];
        $student = student::find($this->getStudentId($request)); //
        $Studentclasses = $student->load('classes')->classes;
        $teacher = teacher::find($idTeacher);
        $terms = $teacher->terms()->get();
        $sDate = new \DateTime($startDate);
        $eDate= new \DateTime($endDate);
        $secDate =new \DateTime($startDate);
        $termsTAB=[];
        while($sDate<=$eDate){
            $secDate = $secDate->modify('+1 day');
            $termsDATA = $terms->where('start_date', '>=', $sDate->format('Y-m-d H:i:s'))->where('start_date', '<=', $secDate->format('Y-m-d H:i:s'));
            $termTab = [];
            foreach ($termsDATA as $term) {
                if($term->classes == null)
                $termTab[] = [
                    'start_date' =>$term->start_date,
                    'end_date' =>$term->end_date,
                    'id' =>$term->id,
                    'classes'=>$term->classes,
                ];
            }
            //
            $classesArr= [];


            foreach ($Studentclasses as $class){
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
            //
            $termsTAB[] =[
                'dayTime' => $sDate->format('Y-m-d'),
                'terms' => $termTab,
                'classes' => $classesArr,
            ];
            $sDate->modify('+1 day');
        }
        return response()->json($termsTAB);
    }
    public function getStudentClasses(request $request){
        $startDate = $request['start_date'];
        $endDate = $request['end_date'];
        $sDate = new \DateTime($startDate);
        $eDate= new \DateTime($endDate);
        $secDate =new \DateTime($startDate);
        $student = student::find($this->getStudentId($request));
        $studentclasses = $student->load('classes')->classes;
        $termsArr =[];
        foreach ($studentclasses as $class){
            $term = $class->load('terms')->terms;
            $classDate = new \DateTime($term->start_date);
            if($sDate<= $classDate
                && $eDate>= $classDate){
            $termsArr [] = [
                'classDate'=> $classDate->format('Y-m-d'),
                "classes"=>[
                "start_date" =>$term->start_date,
                "end_date" =>$term->end_date,
                "teacher"=>$this->getTeacher($term->teacher_id),
                "lesson"=>$this->getLesson($class->lesson_id),
                "confirmed"=>$class->confirmed]
            ];
            }
        }
        $terms =[];
        while($sDate<=$eDate){
            $secDate = $secDate->modify('+1 day');
            $term =[];
            foreach ($termsArr as $t){
                if($t['classDate']==$sDate->format('Y-m-d')){
                   $term[] =$t;
                }
            }
            $terms[]=[
                'classDate'=>$sDate->format('Y-m-d'),
                'classes'=>$term,
            ];
            $sDate->modify('+1 day');
        }



        return response()->json($terms);
    }
    public function getTeacherTerms(request $request){
        $startDate = $request['start_date'];
        $endDate = $request['end_date'];
        $teacher = teacher::find($this->getTeacherId($request));
        $terms = $teacher->terms()->get();
        $sDate = new \DateTime($startDate);
        $eDate= new \DateTime($endDate);
        $secDate =new \DateTime($startDate);
        $termsTAB=[];
        while($sDate<=$eDate){
            $secDate = $secDate->modify('+1 day');
            $termsDATA = $terms->where('start_date', '>=', $sDate->format('Y-m-d H:i:s'))->where('start_date', '<=', $secDate->format('Y-m-d H:i:s'));
            $termTab = [];
            foreach ($termsDATA as $term) {
                $termTab[] = [
                    'start_date' =>$term->start_date,
                    'end_date' =>$term->end_date,
                    'id' =>$term->id,
                    'classes'=>$term->classes,
                ];
            }
            $termsTAB[] =[
                'dayTime' => $sDate->format('Y-m-d'),
                'terms' => $termTab,
            ];
            $sDate->modify('+1 day');
        }
        return response()->json($termsTAB);
    }


    public function deleteTeacherTerm(request $request, terms $terms){
        $terms->delete();
    }



    private function getTeacherId(Request $request){
        $user = $request->user();
        $user = $user->load('teacher');
        $user = $user->teacher;
        return $user['id'];
    }

    private function getTeacher($id)
    {
        $teacher = teacher::find($id);
        return ([
            'id' => $teacher->id,
            'firstName' => $teacher->firstName,
            'lastName' => $teacher->lastName,
        ]);
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
            'subject_level' => $level,
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
            'teacher' => $this->getTeacher($term->teacher_id),
        ]);
    }

}


