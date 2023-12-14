<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClientTraining extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_training', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('training_id');
            $table->integer('attendance')->default(1);
            $table->boolean('has_client_feedback')->default(false);
            $table->text("client_feedback")->nullable(true);
            $table->timestamps();

            $table->unique(['client_id', 'training_id']);
            $table->foreign('client_id')
                ->references('id')
                ->on('instances')
                ->onDelete('cascade');
            $table->foreign('training_id')
                ->references('id')
                ->on('instances')
                ->onDelete('cascade');
        });

        Schema::create('menthor_training', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menthor_id');
            $table->unsignedBigInteger('training_id');
            $table->boolean('has_menthor_feedback')->default(false);
            $table->text("menthor_feedback")->nullable(true);
            $table->timestamps();

            $table->unique(['menthor_id', 'training_id']);
            $table->foreign('menthor_id')
                ->references('id')
                ->on('instances')
                ->onDelete('cascade');
            $table->foreign('training_id')
                ->references('id')
                ->on('instances')
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
        Schema::dropIfExists('client_training');
        Schema::dropIfExists('menthor_training');
    }
}
