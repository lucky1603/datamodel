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
            $table->double('iznos_prihoda')->default(0.0);
            $table->double('iznos_izvoza')->default(0.0);
            $table->unsignedInteger('broj_zaposlenih')->default(0);
            $table->unsignedInteger('broj_angazovanih')->default(0);
            $table->unsignedInteger('broj_angazovanih_zena')->default(0);
            $table->double('iznos_placenih_poreza')->default(0.0);
            $table->double('iznos_ulaganja_istrazivanje_razvoj')->default(0.0);
            $table->unsignedInteger('broj_malih_patenata')->default(0);
            $table->unsignedInteger('broj_patenata')->default(0);
            $table->unsignedInteger('broj_autorskih_dela')->default(0);
            $table->unsignedInteger('broj_inovacija')->default(0);
            $table->unsignedInteger('faza_razvoja')->default(0);
            $table->string('faza_razvoja_tekst');
            $table->unsignedInteger('business_branch')->default(0);
            $table->string('business_branch_text');
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
