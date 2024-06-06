<?php

namespace App\Http\Controllers;

use App\Models\EContent;
use App\Models\Tboards;
use App\Models\TCourses;
use App\Models\TLiveSessions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EContentController extends Controller
{

    public function SuperAdminViewLiveSession()
    {
        $contents = TLiveSessions::get();
        return view('dashboard.superadmin.ecoaching.livesessions.view' , compact('contents'));
    }
    public function SuperAdminCreateLiveSession(Request $request)
    {
        $rqMethod = $request->method();
        if ($rqMethod == 'POST') {
            if ($request->hasFile('live_thumbnail')) {
                $file = $request->file('live_thumbnail');
                $fullpath = $this->saveFile($file, 'web_uploads/ecoaching/thumbnails/');
                $content = new TLiveSessions();
                $content->board_id = $request->board_id;
                $content->course_id = $request->course_id;
                $content->live_thumbnail = $fullpath;
                $content->live_link = $request->live_link;
                $content->live_title = $request->live_title;
                $content->live_subtitle = $request->live_subtitle;
                $content->save();
                return redirect()->route('superadmin.live_session.view');
            }else{
                $boards = Tboards::all();
                $courses = TCourses::all();
                return redirect()->route('superadmin.live_session.create', compact('boards', 'courses'))->with('error', 'Please Upload Thumbnail');
                ;
            }
        }
        $boards = Tboards::all();
        $courses = TCourses::all();
        return view('dashboard.superadmin.ecoaching.livesessions.create' , compact('boards', 'courses'));
    }
    public function SuperAdminViewNotes()
    {
        $contents = EContent::where('type', 'notes')
        ->get();
        return view('dashboard.superadmin.ecoaching.notes.view', compact('contents'));
    }
    public function SuperAdminCreateNotes(Request $request)
    {
        $rqMethod = $request->method();
        if ($rqMethod == 'POST') {
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $file2 = $request->file('content_link');
                $fullpath = $this->saveFile($file, 'web_uploads/ecoaching/thumbnails/');
                $fullpath2 = $this->saveFile($file2, 'web_uploads/ecoaching/notes/');
                $content = new EContent;
                $content->board_id = $request->board_id;
                $content->course_id = $request->course_id;
                $content->type = "notes";
                $content->thumbnail = $fullpath;
                $content->content_link = $fullpath2;
                $content->content_type = "pdf";
                $content->save();
                return redirect()->route('superadmin.notes.view');
            }
        }
        $boards = Tboards::all();
        $courses = TCourses::all();
        return view('dashboard.superadmin.ecoaching.notes.create' , compact('boards', 'courses'));
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
