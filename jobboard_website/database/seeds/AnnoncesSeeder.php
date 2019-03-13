<?php

use App\Annonces;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AnnoncesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('fr-FR');
        for ($i = 0; $i < mt_rand(2,10); $i++){
            $annonce = new Annonces();
            $annonce->title = $faker->sentence();
            $annonce->content = "<p>" . join("</p><p>" , $faker->paragraphs(5)) . "</p>";
            $annonce->datePublication = $faker->date();
            $annonce->position = $i+1;
            $annonce->save();
        }
    }
}
