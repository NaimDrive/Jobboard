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
<<<<<<< HEAD


Route::get('/etudiant/edit_profile', 'EtudiantController@modifierProfile')->name('edit_profile'); //route pour acceder à la modification du profile, à modifier avec la BDD
=======
Route::get('/', 'AccueilController@index')->name('accueil');
Route::get('/connexion', 'HomeController@index')->name('home');
>>>>>>> e1bb06837ad9bfbecd5e0c6ad5ad75cf8fe95d99
