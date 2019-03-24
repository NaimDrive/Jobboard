<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrepriseParticipe extends Model
{
    protected $table = "entreprise_participes";

    function contacts() {
        return $this->hasMany('App\ContactParticipe', 'idEntrepriseParticipe');
    }
    function etudiants() {
        return $this->hasMany('App\EtudiantParticipe', 'idEntrepriseParticipe');
    }

    function entrepriseP() {
        return $this->belongsTo('App\Entreprise','idEntreprise');
    }


}
