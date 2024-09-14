<?php

namespace App\Http\Controllers\Api;

use App\Models\userDescription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class userDescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return userDescription::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userDescription=new userDescription();
        $userDescription->description ='';
        $userDescription->save();
        return $userDescription;
    }

    /**
     * Display the specified resource.
     */
    public function show(userDescription $userDescription)
    {
        return response()->json($userDescription);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, userDescription $userDescription)
    {
        $userDescription->update($request->all());
        return response()->json($userDescription);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(userDescription $userDescription)
    {
        $userDescription->delete();
    }
}
