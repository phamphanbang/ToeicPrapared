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
        Schema::create('training_test', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_history_id')->constrained('training_history')->onDelete('cascade');
            $table->foreignId('test_id')->nullable()->constrained('test')->onDelete('cascade');
            $table->foreignId('test_history_id')->nullable()->constrained('test_history')->onDelete('cascade');
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_test');
    }
};
