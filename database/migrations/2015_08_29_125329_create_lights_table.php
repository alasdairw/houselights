<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lights', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('light_id');
            $table->string('name');
            $table->string('type');
            $table->string('uniqueid');
            $table->string('brightness');
            $table->string('hue');
            $table->string('saturation');
            $table->string('colormode');
            $table->string('effect');
            $table->string('alert');
            $table->string('xy');
            $table->double('x',7,5);
            $table->double('y',7,5);
            $table->boolean('reachable');
            $table->boolean('state');
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
        Schema::drop('lights');
    }
}
