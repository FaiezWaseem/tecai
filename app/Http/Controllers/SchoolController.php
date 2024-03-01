<?php

namespace App\Http\Controllers;

use App\Models\school;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = school::all();
        return view("admin.schools")->with("schools", $schools);
    }
    public function SuperAdminViewSchool()
    {
        $schools = school::all();
        return view("dashboard.superadmin.schools.view")->with("schools", $schools);
    }
    public function SuperAdminDeleteSchool(Request $request){
        if($request->id){
            $deletedRows =  school::destroy($request->id);
            if ($deletedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'deleted' => true
                ]);
            }else{
                return response()->json([
                    'status' => 200,
                    'deleted' => false,
                    'message' => 'Failed To Delete Record'
                ]);
            }
        }else{
            return response()->json([
                'status' => 200,
                'deleted' => false,
                'message' => 'Record Id is not Provided',
                'form' => $request->id
            ]);
        }
    }
    public function SuperAdminCreateSchool(Request $request){
        if($request->school_name){
            $school = new school();
            $school->school_name = $request->input("school_name");
            $school->save();
            return redirect()->route('superadmin.schools.view');
        }else{
            return view('dashboard.superadmin.schools.create');
        }
    }
    public function SuperAdminEditSchool(Request $request){
        if($request->id && $request->school_name){
            $school = school::find($request->id);
            if($request->school_name){
                $school->school_name = $request->input("school_name");
            }
            $school->save();
            return redirect()->route('superadmin.schools.view');
        }else{
            $school = school::find($request->id);
            return view('dashboard.superadmin.schools.edit')
            ->with('school', $school)
            ;
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $school = new school();
        $school->school_name = $request->input("school_name");
        $school->save();
        return redirect()->route('school.show');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\school  $school
     * @return \Illuminate\Http\Response
     */
    public function show(school $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\school  $school
     * @return \Illuminate\Http\Response
     */
    public function edit(school $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\school  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, school $school)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\school  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(school $school)
    {
        //
    }
}
