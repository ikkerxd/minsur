<?php
namespace App\Http\Controllers;
use App\Fotocheck;
use App\UserInscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;


class FotocheckController extends Controller
{
    
    public function solicited(User $user)
    {
        if(!$user->image)
        {
            $message='El participante '. $user->fullname .' necesita tener una foto'; 
            return back()->with('success',$message);
        }

        $fields['user_id']= $user->id;
        $fields['state'] = \App\Fotocheck::SOLICITED;

        $fotocheck= Fotocheck::updateOrCreate(['user_id' =>$user->id],[$fields]);

        $message='El Fotocheck del participante '. $user->fullname .' ha sido solicitado correctamente';  
        return back()->with('success',$message);
    }

    public function list()
    {
        $fotochecks=Fotocheck::with('user')->get();

        return view('fotochecks.index',compact('fotochecks'));
    }
    public function detail(Fotocheck $fotocheck)
    {
        
        $fotocheck->load('user')->first();
        
        $details=UserInscription::with(['user','inscription'])
        ->where('user_inscriptions.id_user',$fotocheck->user->id)
        ->whereIn('user_inscriptions.state',[0,1])
        //->validity()
        ->get();
        return view('fotochecks.detail_fotocheck',compact('fotocheck','details'));
    }

}
