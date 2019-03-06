<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom','prenom', 'email', 'password','picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * renvoi un tableau avec le role de tous les utilisateurs
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() {
        return $this->belongsToMany('App\Role', 'definir', 'idUser', 'idRole');
    }

    public function isEtudiant(){
        foreach ($this->roles as $role){
            if ($role->typeRole == "ETUDIANT")
                return true;
        }
        return false;
    }

    public function isContact(){
        foreach ($this->roles as $role){
            if ($role->typeRole == "CONTACT")
                return true;
        }
        return false;
    }

    public function isAdmin(){
        foreach ($this->roles as $role){
            if ($role->typeRole == "ADMIN")
                return true;
        }
        return false;
    }
}
