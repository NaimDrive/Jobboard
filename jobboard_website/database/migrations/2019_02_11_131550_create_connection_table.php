<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connection', function (Blueprint $table) {
            $table->integer('idUser')->primary();
            $table->integer('idEtudiant')->primary();
            $table->increments('emailUser');
            $table->foreign('idUser')->references('id')->on('users');
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
        Schema::dropIfExists('connection');
    }
}
