<?php

namespace App\Http\Controllers\Api;

use App\Models\student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class studentController extends Controller
{
    public function showProfile(Request $request)
    {
        $user = $request->user();

        $user = $user -> load('student');

        // Zwróć dane zalogowanego użytkownika
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

}
