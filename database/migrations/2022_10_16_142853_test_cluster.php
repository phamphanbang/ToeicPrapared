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
        Schema::create('test_cluster', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_id')->constrained('test_part')->onDelete('cascade');
            $table->integer('order_in_part');
            $table->integer('question_begin');
            $table->integer('question_end');
            $table->text('question');
            $table->string('attachment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_cluster');
    }
};
