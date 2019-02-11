<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offre', function (Blueprint $table) {
            $table->increments('idOffre')->primary();
            $table->string('nomOffre');
            $table->string('natureOffre');
            $table->date('dateDebut');
            $table->date('dateFin');
            $table->string('pre-embauche');
            $table->date('datePublicationOffre');
            $table->string('lienOffre');
            $table->string('depot');
            $table->integer('idEntreprise');
            $table->integer('idTypeOffre');
            $table->foreign('idEntreprise')->references('idEntreprise')->on('entreprise');
            $table->foreign('idTypeOffre')->references('idTypeOffre')->on('offrecherchee');
            
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
        Schema::dropIfExists('offre');
    }
}
