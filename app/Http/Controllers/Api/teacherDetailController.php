<?php

namespace App\Http\Controllers\Api;

use App\Models\teacher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class teacherDetailController extends Controller
{

    public function getTeacherDetail(Request $request){
        $teacherID = $request['teacherID'];
        $teacher = teacher::all()->where('id', $teacherID)->first();
        $teacher = $teacher->load('lesson');
        $lessons = $teacher->lesson->load('subject', 'subjectLevel');

        return response()->json($teacher);
    }
}
