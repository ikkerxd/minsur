<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserInscription extends Model
{
    const ACTIVE = '1';
    const NOT_ACTIVE = '0';

    protected $fillable = [
        'id_inscription','id_user','service_order','voucher','voucher_hash','payment_form',
        'payment_condition','point','condicion',
        'assistence','ruc_subcontrata','subcontrata'
        ,'obs','state','id_user_inscription','code_transaction',
        'id_company_inscription'
    ];
    
    protected $hidden = [
        'created_at','updated_at'
    ];
    //SCOPES
    public function scopeActive($q)
    {
        $q->whereIn('user_inscriptions.state',[0,1]);
    }
    public function scopeInscriptionHasUser($q,$id)
    {
        return $q->where('user_inscriptions.id_user',$id);
    }
    public function scopeNotHasFotocheck($q,$fotocheck)
    {
        //field es el campo que quieres que te muestre
        $field='course_id';
        return $q->whereHas('inscription', function ($q) use($field,$fotocheck) {
            $q->whereNotIn('id_course',$fotocheck->coursesArrayShow($field));
        });
    }
    public function scopehasFotocheck($q,$fotocheck)
    {
        //field es el campo que quieres que te muestre
        $field='course_id';
        return $q->whereHas('inscription', function ($q) use($fotocheck,$field) {
            $q->whereIn('id_course',$this->coursesArrayShow($fotocheck,$field));
        });
    }
    public function scopeFilterCoursesAdmited($q,$user)
    {
        return $q->whereHas('inscription', function ($q) use($user) {
            $q->whereRaw('user_inscriptions.point >= inscriptions.point_min');
            $q->whereIn('id_course',$user->courses_admited_fotocheck);
        });
    }
    
    //FUNCIONES
    public function coursesArrayShow($fotocheck,$field)
    {
        $fotocheck_course_array = [];
        foreach($fotocheck->fotocheck_courses as $fotocheck_course)
        {
            array_push($fotocheck_course_array,$fotocheck_course->$field);
        }
        return $fotocheck_course_array;
    }
    public function vigency()
    {
            if($this->inscription->course->type_validity ==1){
                $date="day";
            }elseif($this->inscription->course->type_validity ==2){
                $date="month";
            }else{
                
                $date="year";
            }
        
        $start_datetime=Carbon::parse($this->inscription->startDate)->format('Y-m-d');
        //'. $inscription->nameCurso.
        $validation = date("Y-m-d", strtotime($start_datetime." + {$this->inscription->validaty} {$date}"));
        

        return $validation;
    }
    public function vigencyState()
    {
        if(Carbon::now() > Carbon::parse($this->vigency()))
        {
            return false;
        }
        return true;
    }
    
    //RELATIONS
    public function inscription () {
        return $this->belongsTo(Inscription::class,'id_inscription');
    }
    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }
}
