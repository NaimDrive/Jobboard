<?php

use App\ContactEntreprise;
use Faker\Generator as Faker;
use Faker\Provider\fr_FR\PhoneNumber;

$factory->define(ContactEntreprise::class, function (Faker $faker) {
    return [
        'nom' => $faker->firstName,
        'prenom' =>$faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'telephone' => $faker->phoneNumber,
        'civilite' => $faker->randomElement(['Monsieur','Madame','Autre']),
    ];
});
