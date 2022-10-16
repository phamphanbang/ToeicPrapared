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
        Schema::create('training_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('training_plan')->onDelete('cascade');
            $table->enum('status',['ongoing','success','failed','dropped']);
            $table->integer('current_score');
            $table->date('date_start');
            $table->date('date_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_history');
    }
};
