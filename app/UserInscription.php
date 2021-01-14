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
    public function scopeActive($q)
    {
        $q->whereIn('user_inscriptions.state',[0,1]);
    }
    public function scopehasFotocheck($q,$fotocheck)
    {
        return $q->where('user_inscriptions.id_user',$fotocheck->user->id);
    }
    public function scopeHasInscription($query)
    {
        return $query->whereHas('inscription', function ($query) {
            $query->whereRaw('user_inscriptions.point >= inscriptions.point_min');
        });
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
    
    public function inscription () {
        return $this->belongsTo(Inscription::class,'id_inscription');
    }
    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }
}
