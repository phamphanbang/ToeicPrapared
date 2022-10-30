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
        Schema::create('part_template', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('test_template')->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->integer('order_in_test');
            $table->integer('num_of_question');
            $table->integer('num_of_answer');
            $table->boolean('have_cluster');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('part_template');
    }
};
