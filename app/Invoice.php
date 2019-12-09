<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'id','id_user_inscription','id_company','id_unity','start_date','end_date','cobros',
        'precio','horas','state','igv', 'process', 'url'
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
}
