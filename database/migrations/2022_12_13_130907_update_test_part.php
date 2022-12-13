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
        Schema::table('part_template', function (Blueprint $table) {
            $table->enum('type',['reading','listening'])->default('reading');
        });
        Schema::table('test_part', function (Blueprint $table) {
            $table->enum('type',['reading','listening'])->default('reading');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
