<?php

namespace App\Http\Controllers\Api;

use App\Models\lesson;
use App\Http\Controllers\Controller;
use App\Models\subjectLevel;
use App\Models\teacher;
use Illuminate\Http\Request;

class lessonController extends Controller
{

    public function addLesson(Request $request){

        if($request->prce<0){
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





    private function getTeacherId(Request $request){
        $user = $request->user();
        $user = $user->load('teacher');
        $user = $user->teacher;
        return $user['id'];
    }

}
