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
        Schema::create('test_template', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('status',['public','onhold'])->default('public');
            $table->enum('type',['fulltest','minitest','parttest'])->default('fulltest');
            $table->integer('num_of_part');
            $table->integer('num_of_question');
            $table->integer('duration')->nullable();
            $table->boolean('have_score_range');
            $table->boolean('have_audio_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_template');
    }
};
