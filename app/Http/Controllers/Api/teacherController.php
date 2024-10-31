<?php

namespace App\Http\Controllers\Api;

use App\Models\teacher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
