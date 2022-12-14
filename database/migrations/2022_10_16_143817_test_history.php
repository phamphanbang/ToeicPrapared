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
        Schema::create('test_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->foreignId('test_id')->constrained('test')->onDelete('cascade');
            $table->timestamps();
            $table->string('duration')->nullable();
            $table->integer('total_question');
            $table->integer('right_question');
            $table->integer('wrong_question');
            $table->integer('empty_question');
            $table->integer('score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_history');
    }
};
