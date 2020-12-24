<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPropertyImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_image', function (Blueprint $table) {
            $table->uuid('property_id')->index();
            $table->foreign('property_id')->references('id')->on('properties');

            $table->uuid('image_id')->index();
            $table->foreign('image_id')->references('id')->on('images');

            $table->integer('order')->index()->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_image');
    }
}
