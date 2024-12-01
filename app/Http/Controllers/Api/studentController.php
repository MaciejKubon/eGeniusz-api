<?php

namespace App\Http\Controllers\Api;

use App\Models\student;
use App\Http\Controllers\Controller;
use App\Models\teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class studentController extends Controller
{
    public function showProfile(Request $request)
    {
        $user = $request->user();
        $user = $user -> load('student');
        return response()->json(
            $user->student
        );
    }
    public function updateProfile(Request $request){
        $user = $request->user();
        $user = $user -> load('student');
        $user -> student->update($request->only('firstName','lastName','birthday'));
        return response()->json(['message' => 'Profil zaktualizowany pomyślnie']);
    }
    public function setStudentImage(Request $request){
        $path = $request->file('image')->store('images', 'public');
        $student = student::find($this->getStudentId($request));
        $student->update(['imgPath' => $path]);
        return response()->json(['message' => 'Profil zaktualizowany pomyślnie']);
    }
    public function getStudentImage(Request $request){
        $student = $request->user()->load('student');
        $student = $student['student'];
        $path = $student['imgPath'];
        $imageUrl = Storage::url($path);
        return response()->json(['imageUrl' => $imageUrl]);
    }



    private function getStudentId(Request $request){
        $user = $request->user();
        $user = $user->load('student');
        $user = $user->student;
        return $user['id'];
    }

}
