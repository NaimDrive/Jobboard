<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetencesCherchee extends Model
{
    protected $table = "competences_cherchee";

    public function competenceEtudiant() {
        return $this->belongsTo('CompetencesEtudiant','idCompEtu');
    }

    public function offre () {
        return $this->belongsTo('Offre', 'idOffre');
    }
}
