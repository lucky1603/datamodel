<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaisingStartsCachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raising_starts_caches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->unsignedInteger("how_innovative");
            $table->string("how_innovative_text");
            $table->unsignedInteger('dev_phase_tech');
            $table->string('dev_phase_tech_text');
            $table->unsignedInteger('dev_phase_business');
            $table->string("dev_phase_business_text");
            $table->unsignedInteger("howdiduhear");
            $table->string('howdiduhear_text');
            $table->unsignedInteger('intellectual_property');
            $table->string('intellectual_property_text');
            $table->unsignedInteger('product_type');
            $table->string('product_type_text');
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
        Schema::dropIfExists('raising_starts_caches');
    }
}
