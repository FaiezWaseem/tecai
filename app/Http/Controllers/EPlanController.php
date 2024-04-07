<?php

namespace App\Http\Controllers;

use App\Models\EPlan;
use App\Models\EPlanCourse;
use App\Models\Tboards;
use App\Models\TCourses;
use Illuminate\Http\Request;

class EPlanController extends Controller
{

    public function SuperAdminViewPlans()
    {
        $plans = EPlan::all();
        return view('dashboard.superadmin.ecoaching.plans.view', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function SuperAdminCreatePlans(Request $request)
    {
        $rqMethod = $request->method();
        if ($rqMethod == 'POST') {
            $plan = new EPlan;
            $plan->plan_name = $request->plan_name;
            $plan->plan_details = $request->plan_details;
            $plan->plan_price = $request->plan_price;
            $plan->save();
            return redirect()->route('superadmin.ecoaching.plans.view');
        }
        return view('dashboard.superadmin.ecoaching.plans.create');
    }

    public function EcoachingStudentPlans(){
        $plans = EPlan::all();
        return response()->json([
            'plans' => $plans,
            'status' => false
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function SuperAdminEditPlan($id)
    {
        $ePlan = EPlan::find($id);
        $courses = TCourses::all();
        $boards = Tboards::all();
        $plan_courses = EPlanCourse::where('plan_id', $id)
            ->join('tcourse', 'e_plan_course.course_id', '=', 'tcourse.id')
            ->join('tboards', 'e_plan_course.board_id', '=', 'tboards.id')
            ->select('e_plan_course.*', 'tcourse.course_name', 'tboards.board_name')
            ->get();
        return view('dashboard.superadmin.ecoaching.plans.edit', compact('ePlan', 'courses', 'boards', 'id', 'plan_courses'));
    }

    public function SuperAdminEditPlanAddCourse(Request $request, $id)
    {
        $rqMethod = $request->method();
        if ($rqMethod == 'POST') {


            $isExists = EPlanCourse::where('plan_id', $id)
                ->where('course_id', $request->tcourse_id)
                ->where('board_id', $request->tboard_id)
                ->first();    

            if (!$isExists) {
                $course = new EPlanCourse;
                $course->plan_id = $id;
                $course->course_id = $request->tcourse_id;
                $course->board_id = $request->tboard_id;
                $course->save();

                $course = EPlanCourse::where('e_plan_course.id','=' , $course->id)
                ->join('tcourse', 'e_plan_course.course_id', '=', 'tcourse.id')
                ->join('tboards', 'e_plan_course.board_id', '=', 'tboards.id')
                ->select('e_plan_course.*', 'tcourse.course_name', 'tboards.board_name')
                ->first();

                return response()->json([
                    'success' => 'Course Added Successfully',
                    'course' => $course,
                    'status' => 200
                ]);
            }
            return response()->json([
                'success' => 'Course Already Added',
                'status' => 201
            ]);

        }
        return redirect()->route('superadmin.ecoaching.plans.view');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EPlan $ePlan)
    {
        //
    }
}
