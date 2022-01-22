<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instance_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('program_name')->nullable();
            $table->string('report_name')->nullable();
            $table->text('report_description')->nullable();
            $table->timestamp('contract_start')->nullable();
            $table->timestamp('contract_check')->nullable();
            $table->boolean('tech_fulfilled')->default(false);
            $table->boolean('business_fulfilled')->default(false);
            $table->boolean('financial_approved')->default(false);
            $table->boolean('narative_approved')->default(false);
            $table->boolean('report_approved')->default(false);
            $table->unsignedSmallInteger('status')->default(0);
            $table->boolean('notif1_sent')->default(false);
            $table->boolean('notif2_sent')->default(false);
            $table->boolean('should_notifiy')->default(false);
            $table->timestamps();

            $table->foreign('instance_id')
                ->on('instances')
                ->references('id')
                ->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
