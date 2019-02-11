<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdressEntrepriseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adressEntreprise', function (Blueprint $table) {
            $table->increments('idAdressE')->primary();
            $table->string('nomRue');
            $table->string('ville');
            $table->string('coordonnePostales');
            $table->integer('idEntreprise');
            $table->foreign('idEntreprise')->references('idEntreprise')->on('entreprise');
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
        Schema::dropIfExists('adressEntreprise');
    }
}
