<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeGroupEntityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_group_entity', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_group_id');
            $table->unsignedBigInteger('entity_id');
            $table->timestamps();

            $table->unique(['attribute_group_id', 'entity_id']);

            $table->foreign('attribute_group_id')
                ->on('attribute_groups')
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
        Schema::dropIfExists('attribute_group_entity');
    }
}
