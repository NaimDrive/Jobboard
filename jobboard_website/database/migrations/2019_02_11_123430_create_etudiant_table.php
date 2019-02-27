<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtudiantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etudiant', function (Blueprint $table) {
            $table->increments('id');
            $table->string('civilite');
            $table->date('DateDeNaissance');
            $table->string('adresse');
            $table->string('codePostal');
            $table->string('ville');
            $table->boolean('actif');
            $table->string('etudes');
            $table->boolean('rechercheStage');
            $table->integer('idUser');
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
        Schema::dropIfExists('etudiant');
    }
}
