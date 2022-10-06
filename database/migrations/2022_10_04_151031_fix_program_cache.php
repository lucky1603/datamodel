<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixProgramCache extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_caches', function(Blueprint $table) {
            $table->unsignedTinyInteger('membership_type')->default(0)->after('workshop_count');
            $table->unsignedInteger('year')->default(0)->after('workshop_count');
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
            $table->removeColumn('membership_type');
            $table->removeColumn('year');
        });
    }
}
