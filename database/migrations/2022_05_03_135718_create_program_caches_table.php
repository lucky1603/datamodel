<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramCachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_caches', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('program_id')->unique();
            $table->integer('program_type')->default(0);
            $table->string('program_type_text');
            $table->string('profile_name');
            $table->string('profile_logo');
            $table->integer('program_status')->default(0);
            $table->string("program_status_text");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_caches');
    }
}
