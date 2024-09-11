<?php

namespace App\Http\Controllers\Api;

use App\Models\accountType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class accountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return accountType::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $accuntType = new accountType();
        if($accuntType::where("name",$data["name"])->exists()) {
            return response()->json(["message" => "Subject already exists"]);
        }else {
            $accuntType->name = $data['name'];
            $accuntType->save();
            return $accuntType;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(accountType $accountType)
    {
        return response()->json($accountType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, accountType $accountType)
    {
        $accountType->update($request->all());
        return response()->json($accountType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(accountType $accountType)
    {
        $accountType->delete();
    }
}
