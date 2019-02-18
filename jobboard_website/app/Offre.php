<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    protected $table = 'offre';

    public function entreprise() {
        return $this->belongsTo('App\Entreprise', 'idEntreprise');
    }

    public function typeOffre() {
        return $this->belongsTo('App\TypeOffre', 'idTypeOffre');
    }

    public function description(){
        return $this->hasOne('App\DescriptionOffre','idOffre');
    }
}
