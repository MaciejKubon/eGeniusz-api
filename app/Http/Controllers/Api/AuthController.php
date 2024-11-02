<?php

namespace App\Http\Controllers\Api;

use App\Models\student;
use App\Models\teacher;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Walidacja danych
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Tworzenie użytkownika
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'accountType'=>$request->accountType,
        ]);
        if($request->accountType == 3)
        {
            $student = new student();
            $student -> user_id = $user->id;
            $student -> save();
        }elseif ($request->accountType == 2){
            $teacher = new teacher();
            $teacher -> user_id = $user->id;
            $teacher -> save();
        }

        // Generowanie tokenu (przykład z użyciem Passport)
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'accountType'=>['required']
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Nieprawidłowe dane logowania'], 401);
    }

}
