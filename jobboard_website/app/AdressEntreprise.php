<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdressEntreprise extends Model
{
    protected $table = "adress_entreprise";

    public function entreprise(){
        return $this->belongsTo('App\Entreprise', 'idEntreprise');
    }
}
