<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetencesEtudiant extends Model
{
    protected $table = 'competences_etudiant';

    public function etudiant() {
        return $this->belongsTo('App\Etudiant' , 'idEtudiant');
    }

    public function categorie() {
        return $this->belongsTo('App\Categorie', 'idCategorie');
    }
}
