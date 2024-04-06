<?php

namespace App\Http\Controllers;

use App\Models\EPlan;
use Illuminate\Http\Request;

class EPlanController extends Controller
{

    public function SuperAdminViewPlans()
    {
        return view('dashboard.superadmin.ecoaching.plans.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(EPlan $ePlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EPlan $ePlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EPlan $ePlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EPlan $ePlan)
    {
        //
    }
}
