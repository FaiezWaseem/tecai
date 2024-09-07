<?php

namespace App\Http\Controllers;

use App\Models\Ecoaching;
use App\Models\school;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
    public function SuperAdminDeleteSchool(Request $request)
    {
        if ($request->id) {
            $deletedRows = school::destroy($request->id);
            if ($deletedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'deleted' => true
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'deleted' => false,
                    'message' => 'Failed To Delete Record'
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'deleted' => false,
                'message' => 'Record Id is not Provided',
                'form' => $request->id
            ]);
        }
    }
    public function SuperAdminCreateSchool(Request $request)
    {
        if ($request->school_name) {
            $school = new school();
            $school->school_name = $request->input("school_name");
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $school->logo = $this->saveFile($file, 'web_uploads/school/logo/');
            }
            if ($request->hasFile('banner')) {
                $file = $request->file('banner');
                $school->banner = $this->saveFile($file, 'web_uploads/school/banner/');
            }

            $school->save();
            return redirect()->route('superadmin.schools.view');
        } else {
            return view('dashboard.superadmin.schools.create');
        }
    }
    public function SuperAdminEditSchool(Request $request)
    {

        if ($request->id && $request->school_name) {



            $school = school::find($request->id);



            if ($request->school_name) {
                $school->school_name = $request->input("school_name");
            }
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $school->logo = $this->saveFile($file, 'web_uploads/school/logo/');
            }
            if ($request->hasFile('banner')) {
                $file = $request->file('banner');
                $school->banner = $this->saveFile($file, 'web_uploads/school/banner/');
            }

            $school->save();

            if ($request->ecoaching) {
                $isExists = Ecoaching::where('school_id', $request->id)->first();
                if (!$isExists) {
                    $c = new Ecoaching;
                    $c->school_id = $request->id;
                    $c->save();
                }
            } else {
                $isExists = Ecoaching::where('school_id', $request->id)->first();
                if ($isExists) {
                    $isExists->delete();
                }
            }

            return redirect()->route('superadmin.schools.view');
        } else {
            $isExists = Ecoaching::where('school_id', $request->id)->first();
            $isActive = $isExists ? true : false;
            $school = school::find($request->id);
            return view('dashboard.superadmin.schools.edit')
                ->with('school', $school)
                ->with('isActive', $isActive)
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


    private function saveFile($file, $path)
    {
        $filename = '';
        if ($file) {
            // Get the original filename
            $originalFilename = $file->getClientOriginalName();
            // Generate a unique filename
            $filename = uniqid() . '-' . $originalFilename . '.' . $file->getClientOriginalExtension();

            $fullPath = $path . $filename;
            Storage::disk('public')->put($fullPath, file_get_contents($file));
            return $fullPath;
        }
        return false;
    }
}
