<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $fillable = [
        'id_course','id_location','startDate','endData','address','time','slot',
        'note','type','state', 'id_user', 'nameCurso', 'price', 'hours',
    ];
    
    protected $hidden = [
        'created_at','updated_at'
    ];

    // public function user_inscriptios()
    // {
    // 	return $this->hasMany(UserInscription::class,'id_inscription');
    // }

    /*EN EL CONTROLADOR*/
    // $inscriptions = Inscription::findOrFail(1);
    //     echo $inscriptions->user_inscriptios;
}
