<?php

namespace App;

use Caffeinated\Shinobi\Traits\ShinobiTrait;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, ShinobiTrait;
    
    protected $fillable = [
        'id_company',
        'type_document',
        'dni',
        'firstlastname',
        'secondlastname',
        'name',
        'position',
        'phone',
        'email',
        'password',
        'code_bloque',
        'medical_exam',
        'management','superintendence','image','image_hash','brith_date'
        ,'gender',
        'origin',
        'address',
        'state',
        'id_user',
        'id_unity',
        'email_valorization',
        'image',
        'image_hash'
    ];

    protected $appends = ['full_name','courses_admited_fotocheck'];

    protected $hidden = [
        'remember_token','created_at','updated_at'
    ];

    public function getShortName()
    {
        return "{$this->name} {$this->last_name}";
    }
    //GETTERS
    public function getCoursesAdmitedFotocheckAttribute()
    {
        $courses_admited=[1,58,60,2,63,66,68,168,61,65,67,64,59,62,186];
        return $courses_admited;
    }

    public function getFullName()
    {
        return ucwords("{$this->secondlastname} {$this->firstlastname} {$this->name}");
    }

    public function getFullNameAttribute()
    {
        return ucwords("{$this->secondlastname} {$this->firstlastname} {$this->name}");
    }
    public function user_inscriptions(){
        return $this->hasMany(UserInscription::class);
    }
    public function inscriptions(){
        return $this->hasMany(Inscription::class,'user_inscriptions');
    }
    public function company()
    {
        return $this->belongsTo(Company::class,'id_company');
    }
    public function fotochecks()
    {
        return $this->hasMany(Fotocheck::class);
    }
    public function hasImage()
    {
        if($this->image)
        {
            return true;
        }else
        {
            return false;
        }
        
    }
}
