<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetToGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_to_goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('total', 8, 2);
            $table->bigInteger('goal_id')->unsigned();
            $table->foreign('goal_id')->references('id')->on('goals');
            $table->bigInteger('budget_id')->unsigned();
            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->bigInteger('office_id')->unsigned();
            $table->foreign('office_id')->references('id')->on('offices');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_to_goals');
    }
}
