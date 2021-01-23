<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;


class Fotocheck extends Model
{
    const SOLICITED = '0';
    const APROBED = '1';
    const CANCELED = '2';

    protected $casts = [
        'courses' => 'array',
    ];
    protected $dates = ['date_emited'];

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
    public function codGenerator()
    {
        return $this->attributes['id'] = str_pad($this->id,8,"0", STR_PAD_LEFT);
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
    
    public function drawingImage($img,$field,$location_x,$location_y)
    {
        $img->text(''.$field.'', $location_x, $location_y, function($font) {
            $font->file(realpath('fonts/foo.ttf'));
            $font->size(30);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');

        
        });
        return $img;
    }
    
    public function writeText()
    {
        return ['324'=>$this->user->name,'389'=>$this->user->firstlastname.' '.$this->user->secondlastname,
        '454'=>$this->user->position,'519'=>$this->user->superintendence,'590' => $this->user->dni,
        '659' => $this->user->company->businessName,'724' =>$this->date_emited->format('Y-m-d'),'795' =>$this->codGenerator()];
    }
    
    
    
    


}
