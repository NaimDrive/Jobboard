<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrepriseParticipe extends Model
{
    protected $table = "entreprise_participe";

    function contacts() {
        return $this->hasMany('ContactParticipe', 'idEntrepriseParticipe');
    }

}
