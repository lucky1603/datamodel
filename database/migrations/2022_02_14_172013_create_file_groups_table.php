<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(true);
            $table->text('note')->nullable(true);
            $table->timestamps();
        });

        Schema::create('file_group_report', function (Blueprint $table) {
            $table->foreignId('file_group_id');
            $table->foreignId('report_id');

            $table->foreign('file_group_id')
                ->on('file_groups')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('report_id')
                ->on('reports')
                ->references('id')
                ->onDelete('cascade');
        });

        Schema::create('file_file_group', function(Blueprint $table) {
            $table->foreignId('file_group_id');
            $table->foreignId('file_id');
            $table->timestamps();

            $table->foreign('file_group_id')
                ->on('file_groups')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('file_id')
                ->on('files')
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
        Schema::table('file_group_report', function(Blueprint $table) {
            $table->dropForeign('file_group_report_file_group_id_foreign');
            $table->dropForeign('file_group_report_report_id_foreign');
            $table->drop();
        });

        Schema::table('file_file_group', function(Blueprint $table) {
            $table->dropForeign('file_file_group_file_group_id_foreign');
            $table->dropForeign('file_file_group_file_id_foreign');
            $table->drop();
        });

        Schema::dropIfExists('file_groups');
    }
}
