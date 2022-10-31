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
        Schema::create('test_part', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('test')->onDelete('cascade');
            $table->string('name');
            $table->integer('order_in_test');
            $table->integer('num_of_question');
            $table->boolean('have_cluster');
            $table->boolean('have_attachment');
            $table->boolean('have_question');
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_part');
    }
};
