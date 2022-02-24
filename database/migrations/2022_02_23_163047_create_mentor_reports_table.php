<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentorReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentor_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id');
            $table->foreignId('program_id');
            $table->timestamps();

            $table->foreign('mentor_id')
                ->on('instances')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('program_id')
                ->references('id')
                ->on('instances')
                ->onDelete('cascade');
        });

        Schema::create('file_group_mentor_report', function(Blueprint $table) {
            $table->foreignId('file_group_id');
            $table->foreignId('mentor_report_id');
            $table->foreign('file_group_id')
                ->on('file_groups')
                ->references('id')
                ->onDelete('cascade');
            $table->foreign('mentor_report_id')
                ->on('mentor_reports')
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
        Schema::table('file_group_mentor_report', function(Blueprint $table) {
            $table->dropForeign('file_group_mentor_report_file_group_id_foreign');
            $table->dropForeign('file_group_mentor_report_mentor_report_id_foreign');
            $table->drop();
        });

        Schema::table('mentor_reports', function(Blueprint $table) {
            $table->dropForeign('mentor_reports_mentor_id_foreign');
            $table->dropForeign('mentor_reports_program_id_foreign');
            $table->drop();
        });

    }
}
