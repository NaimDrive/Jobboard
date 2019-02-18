<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorie')->insert([
            'nomCategorie' => 'ANALYSE',
        ]);
        DB::table('categorie')->insert([
            'nomCategorie' => 'PROGRAMMATION',
        ]);
        DB::table('categorie')->insert([
            'nomCategorie' => 'BASE DE DONNEES',
        ]);
    }
}
