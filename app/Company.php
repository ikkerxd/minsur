<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'businessName','ruc','address','phone','state'
    ];
    
    protected $hidden = [
        'created_at','updated_at'
    ];

    // public function users()
    // {
    // 	return $this->hasMany(User::class,'id_company');
    // }
    
}
