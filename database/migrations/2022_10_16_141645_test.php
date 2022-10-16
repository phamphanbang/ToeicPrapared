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
            $table->enum('status',['finished','draft'])->default('finished');
            $table->integer('num_of_question');
            $table->integer('score_range')->nullable();
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
