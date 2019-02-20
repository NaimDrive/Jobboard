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


//ROUTE GET ACCUEIL
Route::get('/', 'AccueilController@index')->name('accueil');


//ROUTES GET ET POST POUR L'INSCRIPTION
Route::get('/inscription', 'InscriptionController@formRegister')->name('register');
Route::post('/inscription/store', 'InscriptionController@enregistrerUtilisateur')->name('storeUser');


//ROUTES GET D'ACCES A LA GESTION D'ADMINISTRATEUR
Route::get('/admin', 'AdminController@index')->name('admin');
// ROUTES ADMIN GESTION ENTREPRISE
Route::get('/admin/entreprise', 'AdminController@adminEntreprise')->name('administrerUneEntreprise');
Route::get('/admin/entreprise/delete/{id}','AdminController@supprEntreprise')->name('supprimerUneEntreprise');
// ROUTES ADMIN GESTION ETUDIANT
Route::get('/admin/etudiant', 'AdminController@adminEtudiant')->name('administrerUnEtudiant');
Route::get('/admin/etudiant/delete/{id}','AdminController@supprEtudiant')->name('supprimerUnEtudiant');
// ROUTES ADMIN GESTION CONTACT
Route::get('/admin/contact','AdminController@adminContact')->name('administrerUnContact');
Route::get('/admin/contact/delete/{id}','AdminController@supprContact')->name('supprimerUnContact');
// ROUTES ADMIN GESTION OFFRE
Route::get('/admin/offre','AdminController@adminOffre')->name('administrerUneOffre');
Route::get('/admin/offre/delete/{id}','AdminController@supprOffre')->name('supprimerUneOffre');

//ROUTES POST D'AJOUT D'INFORMATIONS POUR L'ETUDIANT
Route::post('/etudiant/enregistrerCompetence','EtudiantController@gererCompetence')->name('enregistrer_competence');
Route::post('/etudiant/enregistrerExperience','EtudiantController@gererExperience')->name('enregistrer_experience');
Route::post('/etudiant/enregistrerActivite','EtudiantController@gererActivite')->name('enregistrer_activite');
Route::post('/etudiant/enregistrerIdentite','EtudiantController@gererIdentite')->name('enregistrer_identite');
Route::post('/etudiant/enregistrerImage','EtudiantController@gererImage')->name('enregistrer_image');



//ROUTES POST DE SUPPRESSION D'INFORMATIONS POUR L'ETUDIANT
Route::post('/etudiant/supprimerCompetence','EtudiantController@supprimerCompetence')->name('supprimer_competence');
Route::post('/etudiant/supprimerActivite','EtudiantController@supprimerActivite')->name('supprimer_activite');
Route::post('/etudiant/supprimerExperience','EtudiantController@supprimerExperience')->name('supprimer_experience');

//ROUTES GET D'ACCES AUX VUES DE L'ETUDIANT
Route::get('/etudiant/{id}/edit_profile','EtudiantController@modifierProfile')->name('edit_profile');
Route::get('/etudiant/{id}','EtudiantController@consulterProfile')->name('consult_profile');


//ROUTES POST D'AJOUT/MODIF D'ENTREPRISE
Route::get('/entreprise/create','EntrepriseController@createEntreprise')->name('creerEntreprise');
Route::post('/entreprise/enregistrer','EntrepriseController@enregistrerEntreprise')->name('enregistrerEntreprise');

Route::get('/entreprise/{id}/edit', 'EntrepriseController@editEntreprise')->name('editEntreprise');
Route::post('/entreprise/store_change', 'EntrepriseController@storeChanges')->name('storeEntrepriseChange');
Route::get('/entreprise/{id}','EntrepriseController@afficheUneEntreprise')->name('afficherUneEntreprise');
Route::get('/entreprises','EntrepriseController@afficherToutes')->name('afficherToutesEntreprises');

//ROUTE POUR LES RECHERCHES ETUDIANT
Route::get('/etudiant/{id}/createrecherche','EtudiantController@modifierrecherche')->name('createrecherche');
Route::post('/etudiant/supprimerRecherche','EtudiantController@supprimerRecherche')->name('supprimer_recherche');
Route::post('/etudiant/enregistrerRecherche','EtudiantController@enregistrerRechercheOffre')->name('enregistrer_recherche');



//ROUTES MODIF CONTACT
Route::get('/contact/{id}/edit', 'ContactController@editContact')->name('editContact');
Route::post('/contact/store_change', 'ContactController@storeChanges')->name('storeContactChange');
Route::get('/contact/{id}','ContactController@afficherUnContact')->name('afficherUnContact');
Route::get('/contacts','ContactController@afficherContacts')->name('afficherToutContacts');


//ROUTES POUR LES OFFRES
Route::get('/offre/create','OffreController@creerOffre')->name('createOffre');
Route::post('/offre/enregistrer','OffreController@enregistrerOffre')->name('enregistrerOffre');
Route::get('/offre/{id}','OffreController@afficherUneOffre')->name('afficherUneOffre');

//ROUTE D'ACCES A LA LISTE DES OFFRES
Route::get('/offres', 'EtudiantController@afficheOffre')->name('offres');

