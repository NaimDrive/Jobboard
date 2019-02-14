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

//redéfinition de la route register
Route::get('/inscription', 'InscriptionController@formRegister')->name('register');
Route::post('/inscription/store', 'InscriptionController@enregistrerUtilisateur')->name('storeUser');


Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/admin/entreprise', 'AdminController@adminEntreprise')->name('administrerUneEntreprise');
Route::get('/admin/entreprise/delete/{id}','AdminController@supprEntreprise')->name('supprimerUneEntreprise');
Route::get('/admin/etudiant', 'AdminController@adminEtudiant')->name('administrerUnEtudiant');
Route::get('/admin/etudiant/delete/{id}','AdminController@supprEtudiant')->name('supprimerUnEtudiant');

Route::get('/', 'AccueilController@index')->name('accueil');

Route::get('/etudiant/edit_profile','EtudiantController@modifierProfile')->name('edit_profile'); //route pour acceder à la modification du profile, à modifier avec la BDD
Route::post('/etudiant/enregistrer','EtudiantController@enregistrerEtudiant')->name('enregistrer_etudiant');
Route::get('/etudiant/{id}','EtudiantController@consulterProfile')->name('consult_profile');

Route::get('/entreprise/create','EntrepriseController@createEntreprise')->name('creerEntreprise');
Route::post('/entreprise/enregistrer','EntrepriseController@enregistrerEntreprise')->name('enregistrerEntreprise');
Route::get('/entreprise/{id}','EntrepriseController@afficheUneEntreprise')->name('afficherUneEntreprise');

Route::get('/connexion', 'HomeController@index')->name('home');
Route::get('404', ['as' => '404', 'uses' => 'ErrorController@notfound']);

