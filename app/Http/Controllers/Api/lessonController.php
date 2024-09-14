<?php

namespace App\Http\Controllers\Api;

use App\Models\lesson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class lessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return lesson::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $lesson = new lesson();
        if($lesson::where("id_teacher",$data["id_teacher"])->exists()
            && $lesson::where("id_subject",$data["id_subject"])->exists()
            && $lesson::where("id_subject_level",$data["id_subject_level"])->exists()){
            return response()->json(["message"=>"invalid value"]);
        }else{
            $lesson-> id_teacher = $data['id_teacher'];
            $lesson->id_subject = $data['id_subject'];
            $lesson->id_subject_level=$data['id_subject_level'];
            $lesson->price=$data['price'];
            $lesson->save();
            return $lesson;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(lesson $lesson)
    {
        return response()->json($lesson);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, lesson $lesson)
    {
        $lesson -> update($request->all());
        return response()->json($lesson);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(lesson $lesson)
    {
        $lesson -> delete();
    }
}
