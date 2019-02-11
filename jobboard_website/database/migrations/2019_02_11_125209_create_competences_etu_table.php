<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetencesEtuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competencesEtu', function (Blueprint $table) {
            $table->increments('idCompEtu')->primary();
            $table->string('nomCompetence');
            $table->string('niveauEstime');
            $table->integer('idEtudiant');
            $table->foreign('idEtudiant')->references('idEtudiant')->on('etudiant');
            $table->integer('idCategorie');
            $table->foreign('idCategorie')->references('idCategorie')->on('categorie');
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
        Schema::dropIfExists('CompetencesEtu');
    }
}
