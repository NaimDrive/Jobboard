<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $table = 'etudiant';

    public function recherches(){
        return $this->hasMany('App\Recherche' , 'idEtudiant');
    }

    public function experiences() {
        return $this->hasMany('App\Experience', 'idEtudiant');
    }

    public function centresDinterets() {
        return $this->hasMany('App\CentreDInteret', 'idEtudiant');
    }

    public function competences() {
        return $this->hasMany('App\CompetencesEtudiant', 'idEtudiant');
    }

    public function formations() {
        return $this->hasMany('App\Formation', 'idEtudiant');
    }

    public function referencesLiens() {
        return $this->hasMany('App\ReferenceLien', 'idEtudiant');
    }

    public function user() {
        return $this->belongsTo('App\User', 'idUser');
    }

    public function fullname(){
        return Etudiant::user()->get(['nom','prenom']);
    }
}
