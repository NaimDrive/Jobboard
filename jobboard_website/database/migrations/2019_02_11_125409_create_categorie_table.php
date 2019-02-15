<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCategorieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorie', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomCategorie');
            $table->timestamps();
        });

        DB::table('categorie')->insert([
            "nomCategorie" => "Analyse",
        ]);
        DB::table('categorie')->insert([
            "nomCategorie" => "Programmation",
        ]);
        DB::table('categorie')->insert([
            "nomCategorie" => "Base de données",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorie');
    }
}
