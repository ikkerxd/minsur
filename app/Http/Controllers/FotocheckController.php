<?php
namespace App\Http\Controllers;
use App\User;
use App\Fotocheck;
use Carbon\Carbon;
use App\UserInscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Observers\FotocheckObserver;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class FotocheckController extends Controller
{
    public function index(User $user , Fotocheck $fotocheck)
    {
        if(!$user->hasImage())
        {
            $message='El participante '. $user->fullname .' necesita tener una foto'; 
            return back()->with('danger',$message);
        }
        $user->load('fotochecks');

        if($this->validationFotocheck($user,$fotocheck))
        {
            $details=UserInscription::with(['user','inscription'])
            ->inscriptionHasUser($user->id)
            ->filterCoursesAdmited($user)
            ->active()
            ->get();
        return view('fotochecks.index',compact('fotocheck','details','user'));
            
        }

        $message='El Fotocheck del participante '. $user->fullname .' esta en proceso';  
        return back()->with('danger',$message);
        
    }
    public function store(Request $request,User $user,Fotocheck $fotocheck)
    {
        if(!$request->course){
            $message= 'Seleccione algun curso porfavor';
            return back()->with('warning',$message);
        }
        $fotocheck->fotocheckSuccessfull($user,$fotocheck);

        $message='El Fotocheck del participante '. $user->fullname .' se solicito exitosamente';  
        return redirect()->route('detail-participant',$user->id)->with('success',$message);
    }

    public function list()
    {
        $fotochecks=Fotocheck::with('user')
        ->solicited()->get();

        return view('fotochecks.list',compact('fotochecks'));
    }

    public function detail(Fotocheck $fotocheck)
    {
        $fotocheck->load('user');

        $details=UserInscription::with(['user','inscription'])
        ->inscriptionHasUser($fotocheck->user->id)
        ->hasFotocheck($fotocheck)
        ->active()
        ->get();
        
        return view('fotochecks.detail_fotocheck',compact('fotocheck','details'));
    }
    
    public function cancel(Fotocheck $fotocheck)
    {
        $fotocheck->fotocheckCancel();

        $message= 'La solicitud del Fotocheck del participante "'.$fotocheck->user->full_name .'" fue Cancelado';
        return redirect()->route('fotochecks.list')->with('error',$message);
    }
    public function accept(Fotocheck $fotocheck)
    {
        if(!$fotocheck->date_emited==null){
                
            $message= 'Este Fotocheck ya ha sido aprobado';
            return back()->with('warning',$message);
        }
        $fotocheck->fotocheckAprobed();
        
        $message= 'El Fotocheck del participante "'.$fotocheck->user->full_name .'" fue Aprobado Exitosamente';
        return back()->with('success',$message);
    }
    public function exportRequeriments()
    {
        
        return Excel::download(Fotocheck::class, 'reporte.xlsx');
    }
    public function validationFotocheck(User $user,$fotocheck)
    {
        if($user->fotochecks->last()==null || $user->fotochecks->last()->state <> 0)
        {
            return true;
        }
    }


}
