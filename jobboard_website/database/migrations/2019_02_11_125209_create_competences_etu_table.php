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
        Schema::create('competences_etudiant', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomCompetence');
            $table->integer('niveauEstime');
            $table->integer('idEtudiant');
            $table->integer('idCategorie');
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
