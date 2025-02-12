<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_calls', function (Blueprint $table) {
            $table->id();
            $table->string('name')->commen("Name of the public call");
            $table->boolean('active')->default(false)->comment("Is this public call active?");
            $table->timestamp('public_call_date')->nullable()->comment("Date of the public call");
            $table->timestamp('public_call_end_date')->nullable()->comment("End date of the public call");
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
        Schema::dropIfExists('public_calls');
    }
}
