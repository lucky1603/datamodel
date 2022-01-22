<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('filelink');
            $table->timestamps();
        });

        Schema::create('attachment_report', function(Blueprint $table) {
            $table->id();
            $table->foreignId('attachment_id');
            $table->foreignId('report_id');
            $table->timestamps();

            $table->unique(['attachment_id', 'report_id']);

            $table->foreign('attachment_id')
                ->on('attachments')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('report_id')
                ->on('reports')
                ->references("id")
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
        Schema::dropIfExists('attachment_report');
        Schema::dropIfExists('attachments');
    }
}
