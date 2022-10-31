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
        Schema::create('test_question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_id')->constrained('test_part')->onDelete('cascade');
            $table->foreignId('cluster_id')->nullable()->constrained('test_cluster')->onDelete('cascade');
            $table->integer('order_in_test');
            $table->text('question')->nullable();
            $table->string('option_1');
            $table->string('option_2');
            $table->string('option_3');
            $table->string('option_4')->nullable();
            $table->string('answer');
            $table->string('attachment')->nullable();;
            $table->text('explanation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_question');
    }
};
