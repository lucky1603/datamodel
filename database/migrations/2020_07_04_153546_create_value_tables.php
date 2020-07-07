<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValueTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Varchar values table.
        Schema::create('varchar_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('instance_id');
            $table->string('value');
            $table->timestamps();

            $table->unique(['attribute_id','instance_id']);
            $table->foreign('attribute_id')->on('attributes')->references('id')->onDelete('cascade');
            $table->foreign('instance_id')->on('instances')->references('id')->onDelete('cascade');
        });

        // Text values table.
        Schema::create('text_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('instance_id');
            $table->text('value');
            $table->timestamps();

            $table->unique(['attribute_id','instance_id']);
            $table->foreign('attribute_id')->on('attributes')->references('id')->onDelete('cascade');
            $table->foreign('instance_id')->on('instances')->references('id')->onDelete('cascade');
        });

        // Integer values table.
        Schema::create('integer_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('instance_id');
            $table->integer('value');
            $table->timestamps();

            $table->unique(['attribute_id','instance_id']);
            $table->foreign('attribute_id')->on('attributes')->references('id')->onDelete('cascade');
            $table->foreign('instance_id')->on('instances')->references('id')->onDelete('cascade');
        });

        // Double values table.
        Schema::create('double_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('instance_id');
            $table->double('value');
            $table->timestamps();

            $table->unique(['attribute_id','instance_id']);
            $table->foreign('attribute_id')->on('attributes')->references('id')->onDelete('cascade');
            $table->foreign('instance_id')->on('instances')->references('id')->onDelete('cascade');
        });

        // Datetime values table.
        Schema::create('datetime_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('instance_id');
            $table->timestamp('value');
            $table->timestamps();

            $table->unique(['attribute_id','instance_id']);
            $table->foreign('attribute_id')->on('attributes')->references('id')->onDelete('cascade');
            $table->foreign('instance_id')->on('instances')->references('id')->onDelete('cascade');
        });

        // Bool values table.
        Schema::create('bool_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('instance_id');
            $table->boolean('value');
            $table->timestamps();

            $table->unique(['attribute_id','instance_id']);
            $table->foreign('attribute_id')->on('attributes')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('varchar_values');
        Schema::dropIfExists('text_values');
        Schema::dropIfExists('integer_values');
        Schema::dropIfExists('double_values');
        Schema::dropIfExists('datetime_values');
        Schema::dropIfExists('bool_values');
    }
}
