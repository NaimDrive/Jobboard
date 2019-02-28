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


//CONNEXION LINKEDIN
Route::get('/redirect', 'SocialAuthLinkedinController@redirect')->name('linkedinConnect');
Route::get('/callback', 'SocialAuthLinkedinController@callback')->name('linkedinTry');
Route::get('/linkedin/choose/{id}', 'InscriptionController@choose')->name('chooseRole');
Route::post('/linkedin/storeChoice/{id}', 'InscriptionController@storeChoice')->name('storeChoice');



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
Route::post('/etudiant/enregistrerModifs','EtudiantController@enregistrerModifs')->name('enregistrer_modifs');


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
Route::get('/offre/{id}/edit','OffreController@editOffre')->name('editOffre');
Route::post('/offre/{id}/store_change', 'OffreController@storeChanges')->name('storeOffreChange');
Route::get('/offres', 'OffreController@afficherOffres')->name('afficherOffres');
Route::get('/offre/{id}/save', 'OffreController@sauvegarder')->name('saveOffre');
Route::get('/offre/{id}/drop', 'OffreController@drop')->name('dropOffre');
Route::get('/offre/{id}/delete', 'OffreController@delete')->name('deleteOffre');


//ROUTE D'ACCES A LA LISTE DES OFFRES
//Route::get('/offres/etu', 'EtudiantController@afficheOffre')->name('offres');

Route::get('/etudiant/{id}/mesRecherches', 'OffreController@offreSaveEtu')->name('offresSave');

//Route d'acces a tout les etudiants
Route::get('/toutLesEtudiant','EtudiantController@AffichettEtu')->name('toutlesEtudiants');

//ROUTE POUR LES FORUMS
//Route::get('/forum/{id}','ForumController@afficherUnForum')->name('afficherUnForum');
Route::get('/forum/create','ForumController@creerUnForum')->name('creerUnForum');
Route::post('/forum/enregistrer','ForumController@enregistrerUnForum')->name('enregistrerUnForum');


//ROUTE DE LA LISTES DES RECHERCHERS

Route::get('/lesrecherches','EtudiantController@listeRecherches')->name('Recherches');