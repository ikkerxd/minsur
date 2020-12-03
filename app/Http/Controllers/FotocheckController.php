<?php
namespace App\Http\Controllers;
use App\Fotocheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;


class FotocheckController extends Controller
{
    
    public function solicited(Request $request)
    {
        
        $user= User::find($request->user_id);
        
        if(!$user->image)
        {
            $message='El participante '. $user->fullname .' nececita tener una foto'; 
            return back()->with('success',$message);
        }

        $fields['user_id']= $user->id;
        $fields['state'] = \App\Fotocheck::SOLICITED;

        $fotocheck= Fotocheck::create($fields);

        $message='El Fotocheck del participante '. $user->fullname .' ha sido solicitado correctamente';  
        return back()->with('success',$message);
    }

}
