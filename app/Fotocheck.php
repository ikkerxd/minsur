<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fotocheck extends Model
{
<<<<<<< HEAD
    const SOLICITED = '0';
    const PENDING = '1';
    const APROBED = '2';
    const CANCELED = '3';

    protected $fillable = ['user_id', 'course', 'date_emited','state'];
    
    protected $hidden = [
        'remember_token','created_at','updated_at'
    ];
    public function users() {
        return $this->belongTo(User::class);
    }

=======
    //
>>>>>>> 871ce2d99e60c3506efe1fe91b89ca6fbf220a58
}
