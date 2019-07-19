<?php

namespace App\Http\Controllers;

use App\UserInscription;
use App\Inscription;
use App\Participant;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Storage;

class UserInscriptionController extends Controller
{

    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'chk_participant' => 'required',
        ],
        [
            'chk_participant.required' => 'Debes seleccionar al menos 1 participante',
        ]);

        // -- disminuimos la cantidad de particpantes
        $slot = DB::table('inscriptions')->where('id',$request->id_inscription)->value('slot');
        $cant_part_selecionados = count($request->chk_participant);
        $resultado = $slot - $cant_part_selecionados;

        $user = Auth::user();
        if ($request->idLocation == 1) {
            $forma_pago = 'a cuenta';
        }
        else {
            $forma_pago = 'al contado';
        }

        if ($resultado >= 0) {

            $id_company = $user->id_company;
            $id_rol = DB::table('role_user')
                ->where('user_id', $user->id)
                ->first()->role_id;

            if ($id_rol == 1) {
                $id_company = 2;
            }

            foreach ($request->chk_participant  as $participant) {

                $anulate_user = DB::table('user_inscriptions')
                    ->where('id_inscription',$request->id_inscription)
                    ->where('id_user', $participant);

                if ($anulate_user->exists()) {
                    $anulate_user->update(['state' => 0]);
                } else {
                    $userInscription = new UserInscription;
                    $userInscription->id_inscription = $request->id_inscription;
                    $userInscription->id_user = $participant; //usurio participante
                    $userInscription->service_order = null;
                    $userInscription->voucher = null;
                    $userInscription->voucher_hash = null;
                    $userInscription->payment_form = $forma_pago;
                    $userInscription->payment_condition = $request->payment_condition;
                    $userInscription->point = 0;
                    $userInscription->condicion = 0;
                    $userInscription->assistence = 0;
                    $userInscription->ruc_subcontrata = null;
                    $userInscription->subcontrata = null;
                    $userInscription->obs = null;
                    $userInscription->state = 0;
                    $userInscription->id_user_inscription = $user->id;
                    $userInscription->code_transaction = null;
                    $userInscription->id_company_inscription = $id_company;
                    $userInscription->save();
                }
            }

            DB::table('inscriptions')->where('id', $request->id_inscription)
                    ->decrement('slot', $cant_part_selecionados);

//            //ENVIO DE CORREO
//            $condicion2 = "";
//            $condiccion = $request->payment_condition;
//            if($condiccion == 0)
//            {
//                $condicion2 = "Contado";
//            }else{
//                $condicion2 = "Credito";
//            }
//
//            $dg = DB::table('locations')
//                ->join('inscriptions','locations.id','=','inscriptions.id_location')
//                ->join('courses','courses.id','=','inscriptions.id_course')
//                ->select('courses.name as nameCouse','locations.name as nameLocation','courses.price as price','inscriptions.startDate as fechaInicio')
//                ->where('inscriptions.id',$request->id_inscription)
//                ->get();
//
//            $price = intval($dg[0]->price) * intval($cant_part_selecionados);
//

            //$this->sendMail_UserInscriptions($businessName,$dg[0]->nameCouse,$dg[0]->nameLocation,$cant_part_selecionados,$request->optradio,$condicion2,$price,$dg[0]->fechaInicio);

            return redirect()->route('detail-inscriptionc', $request->id_inscription);

        }else{
            return redirect()->route("userInscription", $request->id_inscription)->with('error','No puede registrar mas vacantes de los disponibles.');
        }
    }

    public function show(UserInscription $userInscription)
    {
        //
    }

    
    public function edit(UserInscription $userInscription)
    {
        //
    }

    public function update(Request $request, UserInscription $userInscription)
    {
        $id = request()->segment(2);
        $score = $request->input('dni');        
        foreach ($score as $key => $value) {
            $data = array(
                'firstLastName'     => $request->input('apa')[$key],
                'secondLastName'    => $request->input('ama')[$key],
                'name'              => $request->input('name')[$key],
                'dni'               => $request->input('dni')[$key],
                'position'          => $request->input('position')[$key],
                'company'           => $request->input('company')[$key],
                'contrata'           => $request->input('contrata')[$key],
            );
            $idparticipant = $request->input('id_participant')[$key];            
            Participant::whereId($idparticipant)->update($data);
        }
        return redirect()->route('detail-Inscription', ['id' => $id]);
    }

    public function destroy(UserInscription $userInscription)
    {
        //
    }

    public function reschedule_start(Request $request)
    {
        $id_user_inscription_old = $request->id_user_inscription_old;
        $cant_part_select = count($request->chk_reschedule);
        $slot = DB::table('inscriptions')->where('id',$request->id_inscription)->value('slot');
        $resultado = $slot - $cant_part_select;
        $id_user = Auth::id();
        $data_old_inscription = DB::table('user_inscriptions')
        ->where('id',$id_user_inscription_old)
        ->select('service_order','voucher','voucher_hash','payment_form','payment_condition')
        ->get(); 
        $convert_data_old = json_decode($data_old_inscription, true);
        if ($resultado >= 0) {
            $userInscription = new UserInscription;
            $userInscription->id_inscription = $request->id_inscription;
            $userInscription->id_user = $id_user;
            $userInscription->service_order = $convert_data_old[0]['service_order']; 
            $userInscription->quantity = $cant_part_select;
            $userInscription->voucher = $convert_data_old[0]['voucher'];     
            $userInscription->voucher_hash = $convert_data_old[0]['voucher_hash'];
            $userInscription->payment_form = $convert_data_old[0]['payment_form'];
            $userInscription->payment_condition = $convert_data_old[0]['payment_condition'];  
            $userInscription->state = 1;
            $userInscription->save();
            DB::table('inscriptions')->where('id',$request->id_inscription)->decrement('slot', $cant_part_select);

            $id_user_inscription = DB::table('user_inscriptions')->where('id_user',$id_user)->max('id');            
            //actualizar el id_user_inscription de los participantes que vienen de request.

            foreach ($request->chk_reschedule as $key => $value) {
                $participant = Participant::find($value);
                $participant->id_user_inscription = $id_user_inscription;   
                $participant->state = 1;              
                $participant->updated_at = date('Y-m-d H:i:s');
                $participant->save();
            }            
            DB::table('user_inscriptions')->where('id',$id_user_inscription_old)->decrement('quantity', $cant_part_select);

            //BUSCA EL ID DE INSCRIPCION ANTIGUA Y LE AGREGA LA CANTIDAD DE VACANTES QUE DEJO.
            $id_inscription_old =  DB::table('inscriptions')
            ->join('user_inscriptions','inscriptions.id','=','user_inscriptions.id_inscription')
            ->where('user_inscriptions.id',$request->id_user_inscription_old)
            ->select('inscriptions.id as ID')->first()->ID; 
            DB::table('inscriptions')->where('id',$id_inscription_old)->increment('slot', $cant_part_select);

             //$encrypted = Crypt::encryptString($id_user_inscription);
            //return redirect()->route('detail-Inscription', $id_user_inscription);
            return response()->json($id_user_inscription);
        }else{
            return response()->json(0);
        }
    }
    public function cancel_start(Request $request)
    {        
        $id_user_inscription_old = $request->id_user_inscription_old;
        $cant_part_select = count($request->chk_delete);         

        //actualizar el id_user_inscription de los participantes que vienen de request.
        foreach ($request->chk_delete as $key => $value) {
            $participant = Participant::find($value);
            $participant->state = 2;             
            $participant->updated_at = date('Y-m-d H:i:s');
            $participant->save();
        }            

        DB::table('user_inscriptions')->where('id',$id_user_inscription_old)->decrement('quantity', $cant_part_select);

        //BUSCA EL ID DE INSCRIPCION ANTIGUA Y LE AGREGA LA CANTIDAD DE VACANTES QUE DEJO.
        $id_inscription_old =  DB::table('inscriptions')
        ->join('user_inscriptions','inscriptions.id','=','user_inscriptions.id_inscription')
        ->where('user_inscriptions.id',$id_user_inscription_old)
        ->select('inscriptions.id as ID')->first()->ID; 
        DB::table('inscriptions')->where('id',$id_inscription_old)->increment('slot', $cant_part_select);

        $state = 0;
        //SI QUANTITY ESTA EN 0, DESHABILITA LA INSCRIPCION PARA QUE APARESCA ANULADO
        $npar = DB::table('user_inscriptions')
        ->where('id',$id_user_inscription_old)
        ->select('quantity')->first()->quantity;

        if ($npar == 0) {
            $participant = UserInscription::find($id_user_inscription_old);
            $participant->state = 2;             
            $participant->updated_at = date('Y-m-d H:i:s');
            $participant->save();
            $state = 1;
        }

        return response()->json([
            'id' => $id_user_inscription_old,
            'state' => $state
        ]);
        
    }
    public function sendMail_UserInscriptions($rs,$curso,$sede,$quantity,$p_form,$p_condition,$price,$fecha)
    {
        $detra = "";
        if ($price > 700) {
            $detra = "SI";
        }else{
            $detra = "NO";
        }
        
        $to = "victoria.peche@ighgroup.com";
        $subject = "MMG - Sistema Inscripcion";

        $message = "
        <p>Estimados,</p>
        <p>La empresa <strong>$rs</strong> acaba de inscribirse:</p>      
        
        <table style='border-collapse: collapse; width: 79.9296%; height: 91px;' border='1' >
        <tbody>

       

        <tr style='height: 19px;'>
        <td style='width: 50%; height: 19px;'><span style='font-size: 9pt;'><strong>RAZON SOCIAL</strong></span></td>
        <td style='width: 50%; height: 19px; text-align: center;'>$rs</td>
        </tr>    
           
        <tr style='height: 19px;'>
        <td style='width: 50%; height: 19px;'><span style='font-size: 9pt;'><strong>CURSO</strong></span></td>
        <td style='width: 50%; height: 19px; text-align: center;'>$curso</td>
        </tr>   
        <tr style='height: 19px;'>
        <td style='width: 50%; height: 19px;'><span style='font-size: 9pt;'><strong>FECHA</strong></span></td>
        <td style='width: 50%; height: 19px; text-align: center;'>$fecha</td>
        </tr>   
        <tr style='height: 19px;'>
        <td style='width: 50%; height: 19px;'><span style='font-size: 9pt;'><strong>SEDE</strong></span></td>
        <td style='width: 50%; height: 19px; text-align: center;'>$sede</td>
        </tr>      

                   
        <tr style='height: 18px;'>
        <td style='width: 50%; height: 18px;'><span style='font-size: 9pt;'><strong>CANT. PARTICIPANTES</strong></span></td>
        <td style='width: 50%; height: 18px; text-align: center;'>$quantity</td>
        </tr>
        <tr style='height: 18px;'>
        <td style='width: 50%; height: 18px;'><span style='font-size: 9pt;'><strong>FORMA DE PAGO</strong></span></td>
        <td style='width: 50%; height: 18px; text-align: center;'>$p_form</td>
        </tr>
        <tr style='height: 18px;'>
        <td style='width: 50%; height: 18px;'><span style='font-size: 9pt;'><strong>CONDICION PAGO</strong></span></td>
        <td style='width: 50%; height: 18px; text-align: center;'>$p_condition</td>
        </tr>

        <tr style='height: 18px;'>
        <td style='width: 50%; height: 18px;'><span style='font-size: 9pt;'><strong>DETRACCION</strong></span></td>
        <td style='width: 50%; height: 18px; text-align: center;'>$detra</td>
        </tr>

        </tbody>
        </table>
        <p>El comprobante de pago lo podr¨¢s visualizar en el sistema.</p>
        <p>Saludos,<br>Sistema Inscripci¨®n - MMG</p>
        
        ";
       
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
       
        $headers .= 'From: <sistema@ighgroup.com>' . "\r\n";
        $headers .= 'Cc: luis.vega@ighgroup.com,carmen.senisse@ighgroup.com' . "\r\n";

        mail($to,$subject,$message,$headers);
    }
    public function download_file($file)
    {
        $path = public_path('upload/' . $file);
        return response()->download($path);

    }

    public function anulateUserInscription(Request $request, $id) {
        if ($request->ajax()) {
            $userInscription = DB::table('user_inscriptions')
                ->where('id',$id)->update(['state' => 2]);

            return response()->json([
                'message' => 'Fue eliminado orrectamente el Registro de la inscripcion'
            ]);
        }
    }
}

