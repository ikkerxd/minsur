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
    public function scopehasFotocheck($q,$fotocheck)
    {
        return $q->whereHas('inscription', function ($q) use($fotocheck) {
            $q->whereIn('id_course',$fotocheck->courses);
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
