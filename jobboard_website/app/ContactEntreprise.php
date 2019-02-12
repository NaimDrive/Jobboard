<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactEntreprise extends Model
{
    protected $table = 'contact_entreprise';

    public function user (){
        return $this->belongsTo('App\User', 'idUser');
    }

    public function entreprise() {
        return $this->belongsTo('App\Entreprise', 'idEntreprise');
    }
}
