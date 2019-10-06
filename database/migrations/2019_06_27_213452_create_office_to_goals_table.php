<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeToGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_to_goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('goal_id')->unsigned();
            $table->foreign('goal_id')->references('id')->on('goals');
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
        Schema::dropIfExists('office_to_goals');
    }
}
