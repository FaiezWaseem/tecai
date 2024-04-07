<?php

namespace App\Http\Controllers;

use App\Models\EPlan;
use App\Models\EPlanPayment;
use App\Models\EStudents;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class EStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function SuperAdminViewStudents()
    {

        $students = EStudents::leftJoin('e_payment_plan', 'e_payment_plan.student_id', '=', 'e_students.id')
        ->leftJoin('e_plan', 'e_plan.id', '=', 'e_payment_plan.plan_id')
        ->select('e_students.*', 'e_plan.plan_name', 'e_payment_plan.isApproved')
        ->get();
    
        return view('dashboard.superadmin.ecoaching.students.view' , compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function SuperAdminCreateStudents(Request $request)
    {
        $rqMethod = $request->method();
        if ($rqMethod == 'POST') {

            if($request->hasFile('thumbnail')){
            $file = $request->file('thumbnail');
            $fullpath = $this->saveFile($file, 'web_uploads/ecoaching/students/payments/');

            $student = new EStudents;
            $student->name = $request->name;
            $student->email = $request->email;
            $student->password = $request->password;
            $student->save();

            $newPlan = new EPlanPayment;
            $newPlan->student_id = $student->id;
            $newPlan->plan_id = $request->plan_id;
            $newPlan->isApproved = ($request->isApprove === ('on' || '1')) ? true : false;
            $newPlan->start_time = now();
            $newPlan->end_time = now()->addDays(30);
            $newPlan->payment_screenshot = $fullpath;
            $newPlan->save();

            return redirect()->route('superadmin.ecoaching.students.view');
            }else{
                return 'Payment Screenshot is required';
            }
        } else {
            $Eplans = EPlan::all();
            return view('dashboard.superadmin.ecoaching.students.create', compact('Eplans'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EStudents $eStudents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EStudents $eStudents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EStudents $eStudents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EStudents $eStudents)
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
