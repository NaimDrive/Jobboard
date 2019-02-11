<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetenceschercherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competencesCherchee', function (Blueprint $table) {
            $table->integer('idCompEtu')->primary();
            $table->integer('idOffre')->primary();
            $table->foreign('idCompEtu')->references('idCompEtu')->on('competencesEtu');
            $table->foreign('idOffre')->references('idOffre')->on('offre');
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
        Schema::dropIfExists('competencesCherchee');
    }
}
