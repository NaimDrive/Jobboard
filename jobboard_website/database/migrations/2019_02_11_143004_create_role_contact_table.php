<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roleContact', function (Blueprint $table) {
            $table->integer('idRole')->primary();
            $table->integer('role');
            $table->integer('idContact');
            $table->foreign('idContact')->references('idContact')->on('contactEntreprise');
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
        Schema::dropIfExists('roleContact');
    }
}
