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
    public function scopeValidity($q)
    {
        return $q->where('user_inscriptions.point', '>=' ,'i.point_min')
        ->join('inscriptions as i','i.id','user_inscriptions.id_inscription');
        
    }
    public function vigency($detail)
    {
            if($detail->inscription->course->type_validity ==1){
                $date="day";
            }elseif($detail->inscription->course->type_validity ==2){
                $date="month";
            }else{
                $date="year";
            }
        
        $start_datetime=Carbon::parse($detail->inscription->start_date)->format('d-m-Y');

        $validation = strtotime(" {$start_datetime}. + {$detail->inscription->course->validity} {$date}");
        return $validation=Carbon::parse($validation)->format('d-m-Y');
    }
    
    public function inscription () {
        return $this->belongsTo(Inscription::class,'id_inscription');
    }
    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }
}
