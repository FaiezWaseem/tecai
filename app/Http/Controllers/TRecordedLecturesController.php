<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TRecordedLectures;

class TRecordedLecturesController extends Controller
{
    public function index()
    {
        $recorded = TRecordedLectures::Paginate(50);
        return view('admin.content.recorded.view' ,  compact('recorded'));
    }
    public function create(Request $request)
    {
        $validator = $request->validate([
            'photo' => 'required',
        ], [
            'photo.required' => 'The name field is required.',

        ]);
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->extension();
            $filename = time() . '.' . $extension;

            $file->move('recorded_Lecture', $filename);
            $live_thumbnail = 'recorded_Lecture/' . $filename;
            $recorded = new TRecordedLectures();
            $recorded->rec_title = $request->rec_title;
            $recorded->rec_link = $request->rec_link;
            $recorded->rec_thumbnail = $live_thumbnail;
            $recorded->rec_subtitle = $request->rec_subtitle;
            $recorded->save();

            return redirect()->route('admin.content.recordlectures.view');
        }else{
            var_dump($request->all());
        }
    }
    public function getRecorded(){
        return TRecordedLectures::Paginate(50);
    }
}
