<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrepriseParticipe extends Model
{
    protected $table = "entreprise_participes";

    function contacts() {
        return $this->hasMany('App\ContactParticipe', 'idEntrepriseParticipe');
    }

    function entrepriseP() {
        return $this->belongsTo('App\Entreprise','idEntreprise');
    }

}
