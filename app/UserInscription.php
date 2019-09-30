<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInscription extends Model
{
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
}
