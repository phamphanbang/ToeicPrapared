<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->enum('status',['ongoing','success','fail','dropped']);
            $table->integer('initial_score');
            $table->integer('current_score');
            $table->integer('goal_score');
            $table->integer('score_between_test');
            $table->integer('time_between_test');
            $table->timestamp('date_start');
            $table->timestamp('date_end_goal');
            $table->timestamp('date_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_plan');
    }
};
