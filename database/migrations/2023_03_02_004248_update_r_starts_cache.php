<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRStartsCache extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('raising_starts_caches', function(Blueprint $table) {
            $table->string('innovative_area_text')->nullable()->after('product_type_text');
            $table->unsignedSmallInteger('innovative_area')->default(0)->after('product_type_text');
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
            $table->dropColumn('innovative_area');
            $table->dropColumn('innovative_area_text');
        });
    }
}
