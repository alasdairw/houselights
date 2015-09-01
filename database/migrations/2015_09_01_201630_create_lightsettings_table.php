<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLightsettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lightsettings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('brightness');
            $table->string('hue');
            $table->string('saturation');
            $table->string('colormode');
            $table->double('x',7,5);
            $table->double('y',7,5);
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
        Schema::drop('lightsettings');
    }
}
