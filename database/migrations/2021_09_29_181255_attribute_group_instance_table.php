<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AttributeGroupInstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_group_instance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_group_id');
            $table->unsignedBigInteger('instance_id');
            $table->timestamps();

            $table->unique(['attribute_group_id', 'instance_id']);

            $table->foreign('attribute_group_id')
                ->on('attribute_groups')
                ->references('id')
                ->onDelete('cascade');

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
        Schema::dropIfExists('attribute_group_instance');
    }
}
