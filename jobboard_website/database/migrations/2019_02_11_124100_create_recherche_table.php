<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechercheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recherche', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('souhait');
            $table->date('dateDebut');
            $table->date('dateFin');
            $table->string('secteurGeo');
            $table->string('mobilite');
            $table->integer('idEtudiant');
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
        Schema::dropIfExists('recherche');
    }
}
