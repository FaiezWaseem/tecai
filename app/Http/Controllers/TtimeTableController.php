<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ttimetable;
use App\Models\TCourses;
use App\Models\Tboards;
use App\Models\TClasses;
use Carbon\Carbon;

class TtimeTableController extends Controller
{
    public function index(){
        $schedules = Ttimetable::join('tclasses', 'tclasses.id', '=', 'ttime_table.tclass_id')
        ->whereBetween('ttime_table.date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])
        ->get();
        $daysOfWeek = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ];
        
        $schedulesByDay = [];
        
        foreach ($schedules as $schedule) {
            $dayOfWeek = Carbon::parse($schedule->date)->format('l');
            $schedulesByDay[$dayOfWeek][] = $schedule;
        }
        $courses = TCourses::all();
        $boards = Tboards::all();
        $clasess = TClasses::all();
        // return $schedulesByDay;
        return view('admin.content.schedule.view', compact('schedules', 'courses', 'boards', 'clasess','schedulesByDay','daysOfWeek'));
    }
    public function create(Request $request){
        $timetable = new Ttimetable();
        $timetable->tcourse_id = $request->tcourse_id;
        $timetable->tboard_id = $request->tboard_id;
        $timetable->tclass_id = $request->tclass_id;
        $timetable->course_name = $request->course_name;
        $timetable->date = $request->date;
        $timetable->time = $request->time;
        $timetable->save();
        return redirect()->route('admin.content.schedule.view');
    }
    public function getSchedule(){
        $schedules = Ttimetable::join('tclasses', 'tclasses.id', '=', 'ttime_table.tclass_id')
        ->whereBetween('ttime_table.date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])
        ->get();
        $daysOfWeek = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ];
        
        $schedulesByDay = [];
        
        foreach ($schedules as $schedule) {
            $dayOfWeek = Carbon::parse($schedule->date)->format('l');
            $schedulesByDay[$dayOfWeek][] = $schedule;
        }
        return $schedulesByDay;
    }
}
