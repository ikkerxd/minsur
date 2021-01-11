<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $table='inscriptions';
    protected $fillable = [
        'id_course','id_location','startDate','endData','address','time','slot',
        'note','type','state', 'id_user', 'nameCurso', 'price', 'hours',
        'validaty', 'type_validaty',
        'platform', 'platform_id', 'platform_pwd', 'platform_url', 'test_url', 'modality',
    ];
    
    protected $hidden = [
        'created_at','updated_at'
    ];

    protected $dates = [
      'startDate', 'endData',
    ];

    public function user_inscriptions(){
        return $this->hasMany(UserInscription::class);
    }
    
    public function users(){
        return $this->hasMany(User::class,'user_inscriptions');
    }

    public function course()
    {
        return $this->belongsTo(Course::class,'id_course');
    }
}
