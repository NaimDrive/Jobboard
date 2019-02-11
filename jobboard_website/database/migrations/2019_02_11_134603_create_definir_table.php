<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefinirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('definir', function (Blueprint $table) {
            $table->increments('idRole')->primary();
            $table->increments('idUser')->primary();
            $table->foreign('idUser')->references('id')->on('users');
            $table->foreign('idRole')->references('idRole')->on('role');
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
        Schema::dropIfExists('definir');
    }
}
