<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->string('type');
            $table->boolean('nullable')->default(true);
            $table->boolean('unique')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create("attribute_entity", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('entity_id');
            $table->timestamps();

            $table->unique(['attribute_id', 'entity_id']);
            $table->foreign('attribute_id')
                ->on('attributes')
                ->references('id')
                ->onDelete('cascade');
            $table->foreign('entity_id')
                ->on('entities')
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
        Schema::dropIfExists('attribute_entity');
        Schema::dropIfExists('attributes');
    }
}
