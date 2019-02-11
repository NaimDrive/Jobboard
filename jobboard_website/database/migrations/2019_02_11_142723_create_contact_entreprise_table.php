<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactEntrepriseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactEntreprise', function (Blueprint $table) {
            $table->increments('idContact')->primary();
            $table->string('mail');
            $table->string('telephone');
            $table->string('civilite');
            $table->integer('idEntrepise');
            $table->integer('idUser');
            $table->foreign('idEntrepise')->references('idEntrepise')->on('entreprise');
            $table->foreign('idUser')->references('id')->on('users');
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
        Schema::dropIfExists('contactEntreprise');
    }
}
