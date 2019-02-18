<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'typeRole' => 'ADMIN',
        ]);
        DB::table('role')->insert([
            'typeRole' => 'ETUDIANT',
        ]);
        DB::table('role')->insert([
            'typeRole' => 'CONTACT',
        ]);
    }
}
