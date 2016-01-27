<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('file');
            $table->string('title');
            $table->float('length');
            $table->float('height');
            $table->float('width');
            $table->float('volume');
            $table->float('surface');
            $table->float('price');
            $table->float('scale');
            $table->float('scale_min');
            $table->float('scale_max');
            $table->string('unit');
            $table->string('state');
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
        Schema::drop('models');
    }
}
