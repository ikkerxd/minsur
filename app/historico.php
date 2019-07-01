<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    protected $fillable = [
        'fecha','horas','participante','dni','cargo','ruc_old','empresa_old','empresa','id_curso','curso','origen','estado','asistencia','nota'
    ];
    

    // public function user_inscriptios()
    // {
    // 	return $this->hasMany(UserInscription::class,'id_inscription');
    // }

    /*EN EL CONTROLADOR*/
    // $inscriptions = Inscription::findOrFail(1);
    //     echo $inscriptions->user_inscriptios;
}
