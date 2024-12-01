<?php

namespace App\Http\Controllers\Api;

use App\Models\lesson;
use App\Http\Controllers\Controller;
use App\Models\subjectLevel;
use App\Models\teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class lessonController extends Controller
{

    public function addLesson(Request $request){

        if($request->price<0){
            return response()->json(['message' => 'Cena mniejsza niż zero'], 400);
        }
        $lessonList = $this->showTeacher($request);
        $lessonList = $lessonList->original;
        $lessonList = $lessonList->where('teacher_id',$this->getTeacherId($request))
            ->where('subject_id', $request['subject_id'])
            ->where('subject_level_id',$request['subject_level_id']);
        if($lessonList->count() > 0){
            return response()->json(['message' => 'istnieje już lekacja z wybranego przedmiotu o wybranym poziomie'], 400);
        }
        $lesson = lesson::create([
            'teacher_id'=> $this->getTeacherId($request),
            'subject_id'=> $request->subject_id,
            'subject_level_id'=>$request->subject_level_id,
            'price'=>$request->price
        ]);

        return response()->json($lesson );
    }
    public function showTeacher(Request $request)
    {
        $teacher = teacher::find($this->getTeacherId($request));
        $lesson = $teacher->lesson;
        $lesson = $lesson->load('subject','subjectLevel');

        return response()->json($lesson);
    }
    public function editLesson(Request $request, lesson $lesson)
    {
        $data = $request->all();
        $lesson->update($data);
        return response()->json($lesson);

    }
    public function deleteLesson(Request $request, lesson $lesson){
        $lesson->delete();
    }
    public function getTeachersLesson(Request $request)
    {
        $filtrSubject = $request['subjects_id'];
        $filerLevel = $request['levels_id'];
        $filterPriceMin = $request['minPrice'];
        $filterPriceMax = $request['maxPrice'];
        $teacher = teacher::all();
        $teachers =[];
        foreach($teacher as $teach){
            $lesson = $teach->lesson;
            $sub= [];
            $subId=[];
            $levId=[];
            $price=[];
            foreach($lesson as $lessons){
                $sub[]= $lessons->subject['name'] ;
                $subId[]= $lessons->subject_id;
                $levId[]=$lessons->subject_level_id;
                $price[]= $lessons->price;
            }
            $tech = ['id' => $teach['id'],
                'firstName' => $teach['firstName'],
                'lastName' => $teach['lastName'],
                'imageLink'=> Storage::url($teach['imgPath']),
                'subjects' => $sub,
                'price'=>$price,
            ];
            if(count(array_intersect($filtrSubject, $subId))>0 || count($filtrSubject)==0)
            {
                if(count(array_intersect($filerLevel, $levId))>0 || count($filerLevel)==0)
                {
                    if(count($price)>0)
                    {
                        $isBetween = false;
                        foreach($price as $prices){
                            if($prices>=$filterPriceMin && $prices<=$filterPriceMax)
                            {
                                $isBetween = true;
                            }
                        }
                        if($isBetween){
                            $teachers[] = $tech;
                        }
                    }

                    else{
                        $teachers[] = $tech;
                    }



                }

            }



        }
        return response()->json($teachers);
    }




    private function getTeacherId(Request $request){
        $user = $request->user();
        $user = $user->load('teacher');
        $user = $user->teacher;
        return $user['id'];
    }

}
