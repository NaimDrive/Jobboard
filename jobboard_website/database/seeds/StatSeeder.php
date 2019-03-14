<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stat')->insert([
            'nbEtu' => \App\Etudiant::query()->count(),
            'nbEnt' => \App\Entreprise::query()->count(),
            'nbCon' => \App\ContactEntreprise::query()->count(),
            'nbOff' => \App\Offre::query()->count(),
        ]);
    }
}
