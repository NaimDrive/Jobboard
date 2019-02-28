<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactParticipe extends Model
{
    function contact(){
        return $this->belongsTo('App\ContactEntreprise','idContact');
    }
}
