<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience', function (Blueprint $table) {
            $table->increments('idExperience')->primary();
            $table->string('nom');
            $table->date('dateDebut');
            $table->date('dateFin');
            $table->string('resume');
            $table->string('etablissement');
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
        Schema::dropIfExists('experience');
    }
}
