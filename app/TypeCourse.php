<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeCourse extends Model
{
    protected $fillable = [
        'name','state', 'id_unity',
    ];
    
    protected $hidden = [
        'created_at','updated_at'
    ];
}
