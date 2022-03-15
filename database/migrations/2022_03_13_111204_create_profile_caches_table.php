<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileCachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_caches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->unsignedInteger('membership_type');
            $table->string('membership_type_text');
            $table->unsignedInteger('ntp');
            $table->string('ntp_text');
            $table->unsignedInteger('profile_state');
            $table->string('profile_state_text');
            $table->boolean('is_company');
            $table->string('is_company_text');
            $table->string('program_name');
            $table->string('contact_person_name');
            $table->string('contact_person_email');
            $table->string('website')->nullable(true);
            $table->unsignedBigInteger('profile_id')->unique();
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
        Schema::dropIfExists('profile_caches');
    }
}
