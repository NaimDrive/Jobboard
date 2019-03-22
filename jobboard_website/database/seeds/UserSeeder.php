<?php

use App\AdressEntreprise;
use App\ContactEntreprise;
use App\ContactParticipe;
use App\DescriptionOffre;
use App\Entreprise;
use App\EntrepriseParticipe;
use App\Etudiant;
use App\Forum;
use App\Offre;
use App\Recherche;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('fr-FR');

        DB::table('users')->insert([
            'nom'=>'admin',
            'prenom'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('admin'),
        ]);

        DB::table('definir')->insert([
            'idRole'=>1,
            'idUser'=>1,
        ]);
        

        $forum = new Forum();
        $forum->date = $faker->date($format = 'Y-m-d', $max = 'now');
        $forum->heure = $faker->time($format = 'H:i:s', $max = 'now');
        $forum->actif = 1 ;
        $forum->save();


        $entreprises = [];
        $civilite = ['Monsieur','Madame','Autre'];
        $types = ['etudiant','contact'];
        $genres=['male', 'female'];
        for($i = 0; $i < 100; $i++){

            $type = $faker->randomElement($types);
            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId=$faker->numberBetween(1,99). '.jpg';

            $picture.=($genre == 'male' ? 'men/' : 'women/').$pictureId;

            if ($type == 'etudiant')
            {
                $user = new User();
                $user->nom = $faker->lastName;
                $user->prenom = $faker->firstName;
                $user->picture = $picture;
                $user->email = $faker->email;
                $user->password = Hash::make('azerty');
                $user->save();

                DB::table('definir')->insert([
                    'idRole'=>2,
                    'idUser'=>$user->id,
                ]);

                $etudiant = new Etudiant();
                $etudiant->civilite = $faker->randomElement($civilite);
                $etudiant->DateDeNaissance = $faker->date($format = 'Y-m-d', $max = 'now');
                $etudiant->adresse = $faker->secondaryAddress;
                $etudiant->codePostal = $faker->postcode;
                $etudiant->ville = $faker->city;
                $etudiant->idUser = $user->id;
                $etudiant->actif = mt_rand(0,1);
                $etudiant->rechercheStage = mt_rand(0,1);
                $etudiant->etudes = (mt_rand(0,1) ? "DUT" : "LP");
                $etudiant->save();

                if (mt_rand(0,1)) {
                    $recherche = new Recherche();
                    $recherche->idEtudiant = $etudiant->id;
                    $recherche->souhait = $faker->sentence();
                    $recherche->mobilite = $faker->city;
                    $recherche->secteurGeo = $faker->city;
                    $dateDebut = $faker->dateTimeBetween('now');
                    $recherche->dateDebut = $dateDebut;
                    $duration = mt_rand(2,5);
                    $recherche->dateFin = (clone $dateDebut)->modify("+$duration months");
                    $recherche->save();
                }
            }
            else{
                $user = new User();
                $user->nom = $faker->lastName;
                $user->prenom = $faker->firstName;
                $user->picture = $picture;
                $user->email = $faker->email;
                $user->password = Hash::make('azerty');
                $user->save();

                DB::table('definir')->insert([
                    'idRole'=>3,
                    'idUser'=>$user->id,
                ]);

                $contact = new ContactEntreprise();
                $contact->civilite = $faker->randomElement($civilite);
                $contact->telephone;
                $contact->idUser = $user->id;
                $contact->nom = $user->nom;
                $contact->prenom = $user->prenom;
                $contact->mail = $user->email;
                $contact->role = $faker->jobTitle;
                $contact->actif = 1;
                $contact->save();

                if (mt_rand(0,1)){
                    $entreprise = new Entreprise();
                    $entreprise->nom = $faker->company;
                    $entreprise->siret = 12345678901234;
                    $entreprise->description = $faker->paragraph();
                    $entreprise->createur = $contact->id;
                    $entreprise->actif = 1;
                    $entreprise->save();

                    if(mt_rand(0,1)){
                        $entrepriseParticipe = new EntrepriseParticipe();
                        $entrepriseParticipe->idForum = $forum->id ;
                        $entrepriseParticipe->idEntreprise = $entreprise->id ;
                        $entrepriseParticipe->save();

                        $contactParticipe = new ContactParticipe();
                        $contactParticipe->idEntrepriseParticipe = $entrepriseParticipe->id ;
                        $contactParticipe->idContact = $contact->id ;
                        $contactParticipe->save();
                    }

                    $adresses = [];
                    for ($j=0; $j < mt_rand(1,3); $j++){
                        $adresse = new AdressEntreprise();
                        $adresse->nomRue = $faker->secondaryAddress;
                        $adresse->ville = $faker->city;
                        $adresse->coordonnePostales = $faker->postcode;
                        $adresse->idEntreprise = $entreprise->id;
                        $adresse->save();

                        $adresses[] = $adresse->id;
                    }

                    for ($j=0; $j < mt_rand(1,10); $j++){
                        $offre = new Offre();
                        $offre->nomOffre = $faker->sentence();;
                        $offre->natureOffre = $faker->sentence();;
                        $offre->dateDebut = $faker->date($format = 'Y-m-d', $max = 'now');
                        $offre->dateFin = $faker->date($format = 'Y-m-d', $max = 'now');
                        $offre->preembauche = (mt_rand(0,1)? 'oui' : 'non');
                        $offre->datePublicationOffre = $faker->date($format = 'Y-m-d', $max = 'now');
                        $offre->idEntreprise = $entreprise->id;
                        if (mt_rand(0,1)){
                            $offre->lienOffre = $faker->url;
                        }
                        $offre->save();

                        $descriptionOffre = new DescriptionOffre();
                        $descriptionOffre->contexte = $faker->paragraph();
                        $descriptionOffre->objectif = $faker->paragraph();
                        $descriptionOffre->idOffre = $offre->id;
                        $descriptionOffre->location = $faker->randomElement($adresses);
                        $descriptionOffre->save();
                    }

                    $entreprises [] = $entreprise->id;

                    $contact->idEntreprise = $entreprise->id;
                }
                elseif (mt_rand(0,1)){

                    $contact->idEntreprise = $faker->randomElement($entreprises);
                }

                $contact->save();

            }

        }
    }
}
