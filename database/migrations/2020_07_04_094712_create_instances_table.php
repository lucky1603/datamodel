<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entity_id');
            $table->unsignedBigInteger('parent_id')->nullable(true);
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('parent_id')->on('instances')->references('id')->onDelete('cascade');
        });

        Schema::create('instance_to_instance', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instance_id');
            $table->unsignedBigInteger('related_instance_id');
            $table->timestamps();

            $table->unique(['instance_id', 'related_instance_id']);
            $table->foreign('instance_id')->references('id')->on('instances')->onDelete('cascade');
            $table->foreign('related_instance_id')->on('instances')->references('id')->onDelete('cascade');


        });

        Schema::create('attribute_instance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('instance_id');
            $table->timestamps();

            $table->unique(['instance_id', 'attribute_id']);
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
            $table->foreign('instance_id')->on('instances')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_instance');
        Schema::dropIfExists('instances');
        Schema::dropIfExists('intance_to_instance');
        Schema::dropIfExists('instance_to_instance');
    }
}
