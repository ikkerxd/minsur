<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recuperation extends Model
{
    protected $fillable = [
        'point'
    ];

    protected $hidden = [
        'created_at','updated_at'
    ];
}
