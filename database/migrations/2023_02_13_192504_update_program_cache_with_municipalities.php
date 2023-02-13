<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProgramCacheWithMunicipalities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_caches', function(Blueprint $table) {
            $table->string('opstina_text')->after('ntp_text');
            $table->unsignedInteger('opstina')->default(0)->after('ntp_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_caches', function(Blueprint $table) {
            $table->remove('opstina');
            $table->remove('opstina_text');
        });
    }
}
