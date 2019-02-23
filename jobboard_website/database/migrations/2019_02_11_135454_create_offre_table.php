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
            $table->increments('id');
            $table->string('nomOffre');
            $table->string('natureOffre');
            $table->date('dateDebut');
            $table->date('dateFin');
            $table->string('preembauche');
            $table->date('datePublicationOffre');
            $table->string('lienOffre')->nullable();
            $table->string('depot')->nullable();
            $table->integer('idEntreprise');
            
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
