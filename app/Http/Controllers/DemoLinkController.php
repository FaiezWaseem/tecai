<?php

namespace App\Http\Controllers;

use App\Models\Exam;

use App\Models\demostudents;
use App\Models\Tboards;
use App\Models\TClasses;
use Illuminate\Support\Facades\Storage;

use App\Models\Term;
use DB;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Log;
use Redirect;

class DemoLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    // ==================== SCHOOL ADMIN


    // ==================== SCHOOL ADMIN


    public function SuperAdminCreateDemolink(Request $request)
    {
    if ($request->isMethod('POST')) {
        $dstudent = new demostudents;
        $dstudent->board_id = $request->board_id;
        $dstudent->class = $request->class;
        $dstudent->user_name = $request->name;
        $dstudent->password = bcrypt($request->password);
   
            
        $dstudent->save();

        return redirect()->route('superadmin.demolink.view');
    } 
    else {
        $boards = Tboards::all();
        $classes = TClasses::all();     

        return view('dashboard.superadmin.demolink.create')
            ->with('boards', $boards)
            ->with('classes', $classes);
            }
}



public function SuperAdminViewDemolink(Request $request){
    $rqMethod = $request->method();
    if ($rqMethod === 'GET') {
        $demolink = demostudents::all();

        $demolink = demostudents::join('tboards', 'tboards.id', '=', 'democbts.board_id')
        ->select('democbts.*', 'tboards.board_name')                
                  ->paginate(10);
        return view('dashboard.superadmin.demolink.view')->with('demolink', $demolink);
    }
}

public function SuperAdminDeleteDemolink(Request $request)
{
    if ($request->id) {
    
        $deletedRows = demostudents::destroy($request->id);
    
        if ($deletedRows > 0) {
            return response()->json([
                'status' => 200,
                'deleted' => true,
                'message' => 'Demo Link  deleted successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'deleted' => false,
                'message' => 'Failed to delete the demo link.'
            ]);
        }
    } else {
        return response()->json([
            'status' => 400,
            'deleted' => false,
            'message' => 'Record ID is not provided.',
            'form' => $request->id
        ]);
    }
}
}
