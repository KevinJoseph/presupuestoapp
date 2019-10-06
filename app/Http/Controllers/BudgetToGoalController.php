<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\budgetToGoal;
use Illuminate\Support\Facades\DB;

class BudgetToGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return $budgetToGoal = BudgetToGoal::all();
         }else{
             return view('budgetToGoal');
         }
    }
    public function namesBugetGoal(Request $request){
        
        $budgetGoal = DB::table('budget_to_goals')
        ->join('goals', 'budget_to_goals.goal_id', '=', 'goals.id')
        ->join('offices', 'budget_to_goals.office_id', '=', 'offices.id')
        ->join('budgets', 'budget_to_goals.budget_id', '=', 'budgets.id')
        ->select('budget_to_goals.*', 'goals.name as goal_name', 'offices.name as office_name','budgets.name as budget_name')
        ->get();
        return $budgetGoal;
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
        $budgetToGoal = new BudgetToGoal();
        $budgetToGoal->goal_id = $request->get('goal_id');
        $budgetToGoal->budget_id = $request->get('budget_id');
        $budgetToGoal->office_id = $request->get('office_id');
        $budgetToGoal->total = $request->get('total');
        $budgetToGoal->save();
        return $budgetToGoal;
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
        $budgetToGoal = BudgetToGoal::find($id);
        $budgetToGoal->goal_id = $request->get('goal_id');
        $budgetToGoal->budget_id = $request->get('budget_id');
        $budgetToGoal->office_id = $request->get('office_id');
        $budgetToGoal->total = $request->get('total');
        $budgetToGoal->save();
        return $budgetToGoal;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $budgetToGoal = BudgetToGoal::find($id);
        $budgetToGoal->delete();
    }
}
