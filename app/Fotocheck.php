<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Fotocheck extends Model
{
    const SOLICITED = '0';
    const APROBED = '1';
    const CANCELED = '2';

    protected $casts = [
        'courses' => 'array',
    ];

    protected $fillable = ['user_id', 'courses', 'date_emited','state'];
    
    protected $hidden = [
        'remember_token','created_at','updated_at'
    ];
    //RELATIONS
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    //SCOPES
    public function scopeSolicited($q)
    {
        return $q->where('state', self::SOLICITED);
    }
    public function scopeAprobed($q)
    {
        return $q->where('state', self::APROBED);
    }
    public function scopeCanceled($q)
    {
        return $q->where('state', self::CANCELED);
    }
    //FUNCTIONS
    
    public function fotocheckSuccessfull($user,$fotocheck)
    {
        //$fotocheck->update(['date_emited'=> Carbon::now()]);
        $fotocheck->create(['user_id' => $user->id,'state' => Fotocheck::SOLICITED]);
    }
    public function fotocheckAprobed()
    {
        $this->update(['date_emited'=> Carbon::now(),'state' => Fotocheck::APROBED]);
    }
    public function fotocheckCancel()
    {
        $this->update(['state' => Fotocheck::CANCELED]);
    }
    
    
    
    


}
