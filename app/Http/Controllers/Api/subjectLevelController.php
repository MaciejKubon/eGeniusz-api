<?php

namespace App\Http\Controllers\Api;

use App\Models\subjectLevel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class subjectLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return subjectLevel::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $subjectLevel = new subjectLevel();
        if($subjectLevel::where("name", $data["name"])->exists()){
            return response()->json(["message" => "Level already exists!"], 400);
        }
        else{
            $subjectLevel->name = $data["name"];
            $subjectLevel->save();
            return $subjectLevel;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(subjectLevel $subjectLevel)
    {
        return response()->json($subjectLevel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, subjectLevel $subjectLevel)
    {
        $subjectLevel->update($request->all());
        return response()->json($subjectLevel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(subjectLevel $subjectLevel)
    {
        $subjectLevel->delete();
    }
}
