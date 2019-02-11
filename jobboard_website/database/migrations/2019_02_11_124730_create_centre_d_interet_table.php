<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentreDInteretTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centreDinteret', function (Blueprint $table) {
            $table->increments('idInteret')->primary();
            $table->primary('idInteret');
            $table->string('Interet');
            $table->integer('idEtudiant');
            $table->foreign('idEtudiant')->references('idEtudiant')->on('etudiant');
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
        Schema::dropIfExists('centreDinteret');
    }
}
