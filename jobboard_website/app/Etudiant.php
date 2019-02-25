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

    public function offresSaved() {
        return $this->belongsToMany('App\Offre', 'offre_cherchee', 'idEtudiant', 'idOffre');
    }

    public function isSaved($id) {
        foreach ($this->offresSaved as $offre){
            if ($offre->id == $id)
                return true;
        }
        return false;
    }
}
