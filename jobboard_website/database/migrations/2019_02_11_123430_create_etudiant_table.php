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
            $table->increments('idEtudiant')->primary();
            $table->string('civilite');
            $table->date('DateDeNaissance');
            $table->string('mail');
            $table->string('LienExterne');
            $table->string('CoordonnéePostal');
            $table->integer('idUser');
            $table->integer('idReference');
            $table->foreign('idUser')->references('id')->on('users');
            $table->foreign('idReference')->references('idReference')->on('referenceLien');
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
