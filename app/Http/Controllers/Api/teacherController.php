<?php

namespace App\Http\Controllers\Api;

use App\Models\teacher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class teacherController extends Controller
{
    public function showProfile(Request $request)
    {
        $user = $request->user();
        $user = $user -> load('teacher');
        // Zwróć dane zalogowanego użytkownika
        return response()->json(
            $user->teacher
        );
    }
    public function updateProfile(Request $request){
        $user = $request->user();
        $user = $user -> load('teacher');
        $user -> teacher->update($request->only('firstName','lastName','description','birthday'));
        return response()->json(['message' => 'Profil zaktualizowany pomyślnie']);
    }

    public function setTeacherImage(Request $request){
        $path = $request->file('image')->store('images', 'public');
        $teacher = teacher::find($this->getTeacherId($request));
        $teacher->update(['imgPath' => $path]);
        return response()->json(['message' => 'Profil zaktualizowany pomyślnie']);
    }
    public function getTeacherImage(Request $request){
        $teacher = $request->user()->load('teacher');
        $teacher = $teacher['teacher'];
        $path = $teacher['imgPath'];
        $imageUrl = Storage::url($path);
        return response()->json(['imageUrl' => $imageUrl]);
    }



    private function getTeacherId(Request $request){
        $user = $request->user();
        $user = $user->load('teacher');
        $user = $user->teacher;
        return $user['id'];
    }
}
