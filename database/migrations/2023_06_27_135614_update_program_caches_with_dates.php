<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProgramCachesWithDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_caches', function(Blueprint $table) {
            $table->date("contract_signed")->after('membership_type')->nullable();
            $table->date("application_sent")->after("membership_type")->nullable();
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
            $table->dropColumn('contract_signed');
            $table->dropColumn('application_sent');
        });
    }
}
