<?php

namespace App\Http\Controllers\Auth;

use App\Unity;
use App\User;
use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    
    protected $redirectTo = '/home';

    public function showRegistrationForm()
    {
        //$companies = Company::pluck('businessName','id');
        $companies = Company::all();
        // $unities = Unity::all();
        $unities = Unity::where('id', '<>', 5)->get();
        return view('auth.register',compact('companies', 'unities'));
    }

    public function __construct()
    {
        $this->middleware('guest');
    }
    
    protected function validator(array $data)
    {
        
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'dni' => 'required|string|min:6',
//            'dni' => ['required',
//                Rule::unique('users')->where( function ($query) use($data) {
//
//                    $q = $query->join('role_user', 'role_user.id', '=', 'users.id')
//                                ->where('id_company', $data['rs'])
//                                ->where('id_unity', $data['unity'])
//                                ->where('role_user.id', 4);
//
//                    return $q;
//                })]
        ]);
        
    }
    
    protected function create(array $data)
    {
        $existe = DB::table('users')
            ->join('role_user','users.id','=','role_user.user_id')
            ->where('id_company', $data['rs'])
            ->where('id_unity', $data['unity'])
            ->where('role_id', 4)
            ->exists();
        if ($existe) {
            //session()->flash('message', ['danger', 'Solo se puede crear un usuario por unidad minera.']);
            //return redirect('login');
        }
        $user = User::create([
            'id_company' => $data['rs'],
            'id_unity' => $data['unity'],
            'type_document' => $data['type_document'],
            'dni'   => $data['dni'],
            'firstlastname' => $data['firstlastname'],
            'secondlastname' => $data['secondlastname'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'anexo' => '0',
            'password' => bcrypt($data['password']),
            'id_user' => 0,
            'state' => 0,
            'email_valorization' => $data['email_valorization'],
        ]);
        $user->roles()->sync(4);
        $companies = Company::find($data['rs']);
        $data_company = json_decode( json_encode($companies), true);
        //$this->send_email($data_company["ruc"],$data_company["businessName"],$data['email'],$data['password']);
        //$this->send_email_contrata($data['name'],$data['password'],$data['email']);
        return $user;
    }

    public function send_email($ruc,$rs,$usuario,$clave)
    {
        $to = "lvegameza@gmail.com";
        $subject = "Credenciales";

        $message = "
        <html>
        <head>
        <title>Credenciales</title>
        </head>
        <body>
        <p>RUC: $ruc</p>
        <p>RS: $rs</p>
        <p>USUARIO: $usuario</p>
        <p>CLAVE: $clave</p>

        <p>Saludos, <br>Sistema</p>
        
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <sistema@ighgroup.com>' . "\r\n";
        mail($to,$subject,$message,$headers);
    }
    public function send_email_contrata($usuario,$clave,$correo)
    {
        $to =  $correo;
        $subject = "Credenciales Sistema - IGH GROUP";

        $message = "
        <html>
        <head>
        <title>Credenciales MMG</title>
        </head>
        <body>
            <p>Estimado(a) $usuario,</p>
            <p>Sus credenciales para ingresar a nuestro sistema web son:</p>
            <p>usuario: $correo</p>
            <p>clave : $clave</p>
            <p><a href='https://ighgroup.com/mmg/'>https://ighgroup.com/mmg/</a></p>
            <p>Cualquier consulta, no dude en comunicarse con nosotros.</p>
        <p>Saludos, <br>Sistema MMG - IGH GROUP</p>        
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <sistema@ighgroup.com>' . "\r\n";
        mail($to,$subject,$message,$headers);
    }
}
