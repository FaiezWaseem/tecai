<?php

namespace App\Http\Controllers;

use App\Models\Tboards;
use Illuminate\Http\Request;

class BoardController extends Controller
{
 
    public function index()
    {
        $boards = Tboards::all();
        return view('admin.content.board.view', compact('boards'));
    }
    public function SuperAdminViewLMSBoard(){
        $boards = Tboards::all();
        return view('dashboard.superadmin.lms.boards.view', compact('boards'));
    }
    public function SuperAdminCreateLMSBoard(Request $request){
        $requestMethod = $request->method();
        if($requestMethod == 'POST'){
            $boards = new Tboards();
            $boards->board_name = $request->board_name;
            $boards->save();
            return redirect()->route('superadmin.lms.boards.view');
        }else{
            return view('dashboard.superadmin.lms.boards.create');
        }
    }
    public function SuperAdminDeleteLMSBoard(Request $request){
        if($request->id){
            $deletedRows =  Tboards::destroy($request->id);
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
        $boards = new Tboards();
        $boards->board_name = $request->board_name;
        $boards->save();
        return redirect()->route('admin.content.board.view');
    }
}
