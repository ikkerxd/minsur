<?php
namespace App\Http\Controllers;
use App\Fotocheck;
use App\Observers\FotocheckObserver;
use App\UserInscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class FotocheckController extends Controller
{
    
    public function solicited(User $user,Fotocheck $fotocheck)
    {
        if(!$user->hasImage())
        {
            $message='El participante '. $user->fullname .' necesita tener una foto'; 
            return back()->with('danger',$message);
        }
    
        $user->load('fotocheck');
        if($this->validationFotocheck($user,$fotocheck))
        {
            $message='El Fotocheck del participante '. $user->fullname .' ha sido solicitado correctamente';  
            return back()->with('success',$message);
            
        }else
        {
            $message='El Fotocheck del participante '. $user->fullname .' esta en proceso';  
            return back()->with('danger',$message);
        }
    }

    public function list()
    {
        $fotochecks=Fotocheck::with('user')
        ->solicited()->get();

        return view('fotochecks.index',compact('fotochecks'));
    }

    public function detail(Fotocheck $fotocheck)
    {
        
        $fotocheck->load('user');

        $details=UserInscription::with(['user','inscription'])
        ->hasFotocheck($fotocheck)
        ->hasInscription()
        ->active()
        ->get();
        
        return view('fotochecks.detail_fotocheck',compact('fotocheck','details'));
    }
    
    public function update(Request $request,Fotocheck $fotocheck)
    {
        if(!$request->course){
            $message= 'Seleccione algun curso porfavor';
            return back()->with('warning',$message);
        }

        if(!$fotocheck->date_emited==null){
                
            $message= 'Este Fotocheck ya ha sido aprobado';
            return back()->with('warning',$message);
        }else
        {
            $fotocheck->update(['date_emited'=> Carbon::now()]);
        }
        

        $message= 'El Fotocheck del participante "'.$fotocheck->user->full_name .'" fue Aprobado Exitosamente';
        return back()->with('success',$message);
    }

    public function cancel(Fotocheck $fotocheck)
    {
        $fotocheck->update(['state'=> Fotocheck::CANCELED]);

        $message= 'La solicitud del Fotocheck del participante "'.$fotocheck->user->full_name .'" fue Cancelado';
        return redirect()->route('fotochecks.list')->with('error',$message);
    }
    
    public function validationFotocheck(User $user,$fotocheck)
    {
        if($user->fotocheck->last()==null || $user->fotocheck->last()->state <> 0)
        {
            $fotocheck->fotocheckSuccessfull($user,$fotocheck);
            return true;
        }
    }


}
