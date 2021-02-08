<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fotocheck_course extends Model
{
    const REQUIRED= '1';
    const NO_REQUIRED= '2';
    protected $table= 'fotocheck_course';
    protected $fillable = ['fotocheck_id','course_id','attachment','attachment_hash','required'];

    protected $hidden = [
        'remember_token','created_at','updated_at'
    ];
    
    protected function fotochecks()
    {
        return $this->belongsToMany(Fotocheck::class,'fotocheck_id');
    }

    protected function courses()
    {
        return $this->belongsToMany(Course::class,'course_id');
    }
}
