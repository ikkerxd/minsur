<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\UserInscription;
use Illuminate\Support\Facades\DB;


class BuildingController extends Controller
{
	public function check()
	{
		return view('check.index');
	}
	public function valCompany(Request $request)
	{
		\Excel::load($request->excel, function($reader) {

            $excel = $reader->get();

            $reader->each(function($row) {

                if(trim($row->ruc) != ""){
                    if (Company::where('ruc', '=', $row->ruc)->exists()) {
                     echo DB::table('companies')->select('id')->where('ruc',$row->ruc)->First()->id."<br>";
                     }else{
                        $company = new Company;
                        $company->ruc = $row->ruc;
                        $company->businessName = $row->empresa;
                        $company->address = "";
                        $company->phone = 0;
                        $company->state = 0;
                        $company->save();
                        echo $company->id."<br>";
                    }
            }else{
                echo "columna RUC vacio<br>";
            }
        });

        });
    }

    public function valUser(Request $request)
    {
        \Excel::load($request->excel, function($reader) {
            $excel = $reader->get();

            $reader->each(function($row) {
                if(trim($row->dni_ce) != "")
                {
                    $user = DB::table('users')->join('role_user','users.id','=','role_user.user_id')
                    ->select('users.id as ID')
                    ->where('dni',$row->dni_ce)
                    ->where('role_id',5)
                    ->first();
                    if ($user != null) {
                     echo $user->ID."<br>";
                 }else{
                    $participant = new User();
                    $participant->id_company = $row->id_company;
                    $participant->type_document = 0;
                    $participant->dni = $row->dni_ce;
                    $participant->firstlastname = $row->ap_paterno;
                    $participant->secondlastname = $row->ap_materno;
                    $participant->name = $row->nombres;
                    $participant->position = $row->cargo;
                    $participant->phone = 0;
                    if ($row->email != "") {
                        $participant->email = $row->email;
                    }else{
                        $participant->email = $row->ap_paterno."@demo.com";
                    }
                    $participant->password = bcrypt(md5($row->paterno));
                    $participant->remember_token = "";
                    $participant->code_bloqueo = "";
                    $participant->medical_exam = null;
                    $participant->id_management = 58;
                    $participant->superintendence = 0;
                    $participant->image = "";
                    $participant->image_hash = "";
                    $participant->birth_date = $row->fec_nac;
                    $participant->gender = "";
                    if ($row->procedencia == "Arequipa") {
                        $participant->origin = 1;
                    }elseif($row->procedencia == "Cuzco" || $row->procedencia == "Cusco"){
                        $participant->origin = 2;
                    }else{
                        $participant->origin = 0;
                    }
                    $participant->address = "";
                    $participant->state = 0;
                    $participant->id_user = 0;
                    $participant->save();
                    $participant->roles()->sync(5);
                    echo $participant->id."<br>";
                }
            }else{
                echo "columna DNI vacio<br>";
            } 
        });

        });

    }
    public function register_upload_participants(Request $request)
    { 
        \Excel::load($request->excel, function($reader) use ($request) {

            $excel = $reader->get();

            $reader->each(function($row) use ($request){
                if (trim($row->id_company) != "" && trim($row->id_user != "")) {
                    $userInscription = new UserInscription;
                    $userInscription->id_inscription = $request->id_inscription;
                    $userInscription->id_user = $row->id_user;
                    $userInscription->service_order = null;
                    $userInscription->voucher = null;
                    $userInscription->voucher_hash = null;
                    $userInscription->payment_form = 0;
                    $userInscription->payment_condition = 0;
                    $userInscription->point = $row->nota;
                    $userInscription->condicion = 0;
                    $userInscription->assistence = $row->asistencia;
                    $userInscription->ruc_subcontrata = $row->ruc_c;
                    $userInscription->subcontrata = $row->empresa_c;
                    $userInscription->obs = null;
                    $userInscription->state = 0;
                    $userInscription->id_user_inscription = 0;
                    $userInscription->code_transaction = 0;
                    $userInscription->save();
                    echo "Se registro con ID ".$userInscription->id."<br>";
                }else{
                    echo "No existe ID de empresa o participante<br>";
                }

            });

        });

        
    }

}