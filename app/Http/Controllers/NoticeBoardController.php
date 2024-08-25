<?php

namespace App\Http\Controllers;

use App\Models\NoticeBoard;
use Illuminate\Http\Request;

class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function SchoolAdminViewNoticeBoard()
    {
        $schoolId = HelperFunctionsController::getUserSchoolsIds();
        $notices = NoticeBoard::whereIn('school_id',$schoolId)
        ->get();
        return view('dashboard.admin.noticeboard.view',compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function SchoolAdminCreateNoticeBoard(Request $request)
    {

        $method = $request-> method();

        if($method == 'POST'){
            $message = $request->message;
            $board  = new NoticeBoard;
            $board->message = $message;
            $board->school_id = $request->school_id;
            $board->save();
            return redirect()->route('schooladmin.notice.board.view');
        }

        $schools = HelperFunctionsController::getUserSchools();

        return view('dashboard.admin.noticeboard.create' , compact('schools'));
    }


    public function SchoolAdminDeleteNoticeBoard(Request $request){
        if($request->id){
            $deletedRows =  NoticeBoard::destroy($request->id);
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
}
