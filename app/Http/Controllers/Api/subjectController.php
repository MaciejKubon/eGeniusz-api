<?php

namespace App\Http\Controllers\Api;

use App\Models\subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class subjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return subject::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $subject = new subject();
        if($subject::where("name", $data["name"])->exists()){
            return response()->json(["message" => "Subject already exists"]);
        }
        else{
            $subject-> name=$data['name'];
            $subject->save();;
            return $subject;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(subject $subject)
    {
        return response()->json($subject);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, subject $subject)
    {
        $subject->update($request->all());
        return response()->json($subject);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(subject $subject)
    {
        $subject->delete();
    }
}
