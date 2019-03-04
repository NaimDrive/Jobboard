<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $table='forums';

    function entreprises() {
        return $this->hasMany('App\EntrepriseParticipe', 'idForum');
    }

}
