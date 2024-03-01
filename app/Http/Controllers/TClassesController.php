<?php

namespace App\Http\Controllers;

use App\Models\TClasses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TClassesController extends Controller
{
    public function index(){
       $clasess =  TClasses::all();
       return view('admin.content.class.view', compact('clasess'));
    }
    public function SuperAdminViewLMSClasses(){
        $clasess =  TClasses::all();
        return view('dashboard.superadmin.lms.classes.view')
        ->with('clasess', $clasess)
        ;
    }
    public function SuperAdminCreateLMSClasses(Request $request){
        $requestMethod = $request->method();
        if($requestMethod === 'POST'){
            $filename = '';
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');

                // Generate a unique filename
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();

                // Store the file in the public disk
                Storage::disk('public')->put($filename, file_get_contents($file));
            }
            $clasess = new TClasses();
            $clasess->class_name = $request->class_name;
            $clasess->thumbnail = $filename;
            $clasess->save();
            return redirect()->route('superadmin.lms.classes.view');
        }else{
            return view('dashboard.superadmin.lms.classes.create');
        }
    }

    public function SuperAdminEditLMSClasses(Request $request){
        $requestMethod = $request->method();
        if($requestMethod === 'PUT'){
            $filename = '';
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');

                // Generate a unique filename
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();

                // Store the file in the public disk
                Storage::disk('public')->put($filename, file_get_contents($file));
            }
            $class = TClasses::find($request->id);
            $class->class_name = $request->class_name;
            if($filename !== ''){
                $class->thumbnail = $filename;
            }
            $class->save();
            return redirect()->route('superadmin.lms.classes.view');
        }else{
            $class = TClasses::find($request->id);
            return view('dashboard.superadmin.lms.classes.edit', compact('class'));
        }        
    }
    public function SuperAdminDeleteLMSClasses(Request $request){
        if($request->id){
            $deletedRows =  TClasses::destroy($request->id);
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
    public function create(Request $request){

        $clasess = new TClasses();
        $clasess->class_name = $request->class_name;
        $clasess->save();
        return redirect()->route('admin.content.classes.view');
    }
}
