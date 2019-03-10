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
            'nbEtu' => 0,
            'nbEnt' => 0,
            'nbCon' => 0,
            'nbOff' => 0,
        ]);
    }
}
