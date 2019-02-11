<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescriptionOffreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descriptionOffre', function (Blueprint $table) {
            $table->increments('idDescriptionOffre')->primary();
            $table->string('contexte');
            $table->string('objectif');
            $table->string('location');
            $table->integer('idOffre');
            $table->foreign('idOffre')->references('idOffre')->on('offre');
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
        Schema::dropIfExists('descriptionOffre');
    }
}
