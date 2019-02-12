<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/admin/entreprise', 'AdminController@adminEntreprise')->name('administrerUneEntreprise');

Route::get('/', 'AccueilController@index')->name('accueil');

Route::get('/etudiant/create','EtudiantController@creerEtudiant')->name('creer_etudiant');
Route::get('/etudiant/edit_profile','EtudiantController@modifierProfile')->name('edit_profile'); //route pour acceder à la modification du profile, à modifier avec la BDD
Route::post('/etudiant/enregistrer','EtudiantController@enregistrerEtudiant')->name('enregistrer_etudiant');
Route::get('/etudiant/{id}','EtudiantController@consulterProfile')->name('consult_profile');

Route::get('/entreprise/create','EntrepriseController@createEntreprise')->name('creerEntreprise');
Route::post('/entreprise/enregistrer','EntrepriseController@enregistrerEntreprise')->name('enregistrerEntreprise');
Route::get('/entreprise/{id}','EntrepriseController@afficheUneEntreprise')->name('afficherUneEntreprise');

Route::get('/connexion', 'HomeController@index')->name('home');

