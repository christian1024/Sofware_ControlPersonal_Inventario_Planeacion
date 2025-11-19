<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
//use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable, HasRolesAndPermissions;
    //use Notifiable,HasRoles;

    /**
     *
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dateFormat = 'd-m-Y H:i:s';

    protected $fillable = [
        'id_Empleado', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
