<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::disableForeignKeyConstraints();	
        // Schema::dropIfExists('reports');
        // Schema::dropIfExists('company_stat_country');        
        // Schema::dropIfExists('company_stats');
        // Schema::dropIfExists('countries');
        // Schema::enableForeignKeyConstraints();

        Schema::create("countries", function (Blueprint $table) {
            $table->id("id");
            $table->string("code", 2)->nullable();
            $table->string("country",44)->nullable();
        });

        Schema::create('company_stats', function (Blueprint $table) {
            $table->id();
            $table->decimal('iznos_prihoda')->default(0.0);
            $table->decimal('iznos_izvoza')->default(0.0);
            $table->unsignedSmallInteger('faza_razvoja')->default(0);
            $table->unsignedSmallInteger('broj_zaposlenih')->default(0);
            $table->unsignedSmallInteger('broj_angazovanih')->default(0);
            $table->unsignedSmallInteger('broj_angazovanih_zena')->default(0);
            $table->unsignedSmallInteger('women_founders_count')->default(0);
            $table->unsignedSmallInteger('broj_povratnika_iz_inostranstva')->default(0);
            $table->unsignedSmallInteger('broj_malih_patenata')->default(0);
            $table->unsignedSmallInteger('broj_patenata')->default(0);
            $table->unsignedSmallInteger('broj_autorskih_dela')->default(0);
            $table->unsignedSmallInteger('broj_inovacija')->default(0);
            $table->unsignedSmallInteger('broj_zasticenih_zigova')->default(0);
            $table->decimal('iznos_placenih_poreza')->default(0.0);
            $table->decimal('iznos_ulaganja_istrazivanje_razvoj')->default(0.0);
            $table->decimal('investicije_vc_fond')->default(0.0);
            $table->decimal('investicije_angels_investors')->default(0.0);
            $table->decimal('investicije_grant')->default(0.0);
            $table->decimal('investicije_3f')->default(0.0);
            $table->decimal('investicije_other')->default(0.0);

            $table->tinyInteger('statistic_sent')->default(0);
            $table->timestamps();
        });

        Schema::create('company_stat_country', function(Blueprint $table) {
            $table->foreignId('country_id');
            $table->foreignId('company_stat_id');

            $table->unique(['country_id', 'company_stat_id']);
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->cascadeOnDelete();
            $table->foreign('company_stat_id')
                ->references('id')
                ->on('company_stats')
                ->cascadeOnDelete();
        });

        Schema::table('reports', function(Blueprint $table) {
            $table->unsignedBigInteger('company_stat_id')->nullable(true)->after('status');
            $table->foreign('company_stat_id')
                ->references('id')
                ->on('company_stats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('reports', function(Blueprint $table) {
        //     $table->dropForeign('reports_company_stat_id_foreign');
        //     $table->dropColumn('company_stat_id');
        // });

        Schema::dropIfExists('company1_stat_country');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('company_stats');
    }
}
