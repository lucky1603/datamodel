<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixRaisingStartsCache extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('raising_starts_caches', function(Blueprint $table) {
            $table->unsignedInteger('year')->default(0)->after('product_type_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('raising_starts_caches', function(Blueprint $table) {
            $table->removeColumn('year');
        });
    }
}
