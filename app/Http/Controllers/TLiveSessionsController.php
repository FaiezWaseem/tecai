<?php

namespace App\Http\Controllers;

use App\Models\TLiveSessions;
use Illuminate\Http\Request;

class TLiveSessionsController extends Controller
{
    public function index(){
        $live_sessions = TLiveSessions::Paginate(10);
        return view('admin.content.livesessions.view', compact('live_sessions'));
    }
    public function create(Request $request){
        $validator = $request->validate([
            'photo' => 'required',
        ], [
            'photo.required' => 'The name field is required.',

        ]);
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $extension = $file->extension();
            $filename = time(). '.'. $extension;
            
            $file->move('livesessions', $filename);
            $live_thumbnail = 'livesessions/'. $filename;

            $live_sessions = new TLiveSessions();
            $live_sessions->live_title = $request->live_title;
            $live_sessions->live_link = $request->live_link;
            $live_sessions->live_thumbnail = $live_thumbnail;
            $live_sessions->live_subtitle = $request->live_subtitle;
            $live_sessions->save();
            return redirect()->route('admin.content.livesessions.view');
        }
        
        return redirect()->route('admin.content.livesessions.view');
    }
    public function getLives(){
        $live_sessions = TLiveSessions::Paginate(10);
        return $live_sessions;
    }
}
