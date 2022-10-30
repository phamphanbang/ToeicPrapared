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
        Schema::create('cluster_template', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_id')->constrained('part_template')->onDelete('cascade');
            $table->integer('num_in_part');
            $table->integer('num_of_question');
            $table->boolean('have_attachment');
            $table->boolean('have_question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cluster_template');
    }
};
