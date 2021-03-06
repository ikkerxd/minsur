<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'id_type_course','name','hh','state', 'required', 'validaty', 'type_validaty', 'point_min'
    ];
    
    protected $hidden = [
        'created_at','updated_at'
    ];
}
