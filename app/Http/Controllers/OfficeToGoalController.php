<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OfficeToGoal;
use Illuminate\Support\Facades\DB;

class OfficeToGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $officesToGoals = DB::table('office_to_goals')
            ->join('goals', 'office_to_goals.goal_id', '=', 'goals.id')
            ->join('offices', 'office_to_goals.office_id', '=', 'offices.id')
            ->select('office_to_goals.*', 'goals.name as goal_name', 'offices.name as office_name')
            ->get();
        return $officesToGoals;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $officeToGoal = new OfficeToGoal();
        $officeToGoal->goal_id = $request->get('goal_id');
        $officeToGoal->office_id = $request->get('office_id');
        $officeToGoal->save();
        return $officeToGoal;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $officeToGoal = OfficeToGoal::find($id);
        $officeToGoal->goal_id = $request->get('goal_id');
        $officeToGoal->office_id = $request->get('office_id');
        $officeToGoal->save();
        return $officeToGoal;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $officeToGoal = OfficeToGoal::find($id);
        $officeToGoal->delete();
    }
}
