<?php

namespace App;

use Caffeinated\Shinobi\Traits\ShinobiTrait;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, ShinobiTrait;
    
    protected $fillable = [
        'id_company',
        'type_document',
        'dni',
        'firstlastname',
        'secondlastname',
        'name',
        'position',
        'phone',
        'email',
        'password',
        'code_bloque',
        'medical_exam',
        'management','superintendence','image','image_hash','brith_date'
        ,'gender',
        'origin',
        'address',
        'state',
        'id_user',
        'id_unity',
        'email_valorization',
    ];
    
    protected $hidden = [
        'remember_token','created_at','updated_at'
    ];
}
