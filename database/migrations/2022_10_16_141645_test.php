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
        Schema::create('test', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_type_id')->constrained('test_template');
            $table->foreignId('comment_set_id')->constrained('comment_set');
            $table->string('name');
            $table->enum('status',['public','onhold'])->default('public');
            $table->integer('num_of_question');
            $table->integer('score_range')->nullable();
            $table->string('audio_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test');
    }
};
