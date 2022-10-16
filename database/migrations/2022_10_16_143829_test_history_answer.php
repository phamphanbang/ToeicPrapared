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
        Schema::create('test_history_answer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('test_question')->onDelete('cascade');
            $table->foreignId('history_id')->constrained('test_history')->onDelete('cascade');
            $table->string('answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_history_answer');
    }
};
