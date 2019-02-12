<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleContact extends Model
{
    protected $table = 'role_contact';

    public function roleContact() {
        return $this->belongsTo('App\Contact', 'idContact');
    }
}
