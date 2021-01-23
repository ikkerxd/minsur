<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use App\Management;
use Illuminate\Http\Request;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Excel;
use File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\DocBlock\Tags\Method;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users.create')->only(['create', 'store']);
        $this->middleware('permission:users.create')->only(['create']);
        $this->middleware('permission:users.index')->only('index');
        $this->middleware('permission:users.edit')->only(['edit', 'update']);
        $this->middleware('permission:users.show')->only('show');
        $this->middleware('permission:users.destroy')->only('destroy');
    }

    public function index()
    {
        $users = User::all();
        return view('users.index',compact('users'));
    }

    public function fotocheck()
    {
        return view('fotocheck.index');
    }

    public function create()
    {
        $companies = Company::pluck('businessName','id');
        $roles = Role::get();
        $managements = Management::pluck('name','id');
        return view('users.create',compact('roles','companies','managements'));
    }

    public function store(Request $request)
    {
        $idUser = Auth::id();
        $participant = new User();
        $participant->id_company = $request->id_company;
        $participant->type_document = $request->type_document;
        $participant->dni = $request->dni;
        $participant->firstlastname = $request->firstlastname;
        $participant->secondlastname = $request->secondlastname;
        $participant->name = $request->name;
        $participant->position = $request->position;
        $participant->phone = $request->phone;
        $participant->email = $request->email;
        $participant->password = bcrypt(md5($request->password));
        $participant->remember_token = null;
        $participant->code_bloqueo = null;
        $participant->medical_exam = $request->medical_exam;
        $participant->id_management = $request->id_management;
        $participant->superintendence = $request->superintendence;
        $participant->image = null;
        $participant->image_hash = null;
        $participant->birth_date = $request->birth_date;
        $participant->gender = $request->gender;
        $participant->origin = $request->origin;
        $participant->address = $request->address;
        $participant->state = 0;
        $participant->id_user = $idUser;
        $participant->save();
        $participant->roles()->sync($request->get('roles'));
        return redirect()->route('users.index')->with('success','El usuario fue registrada');

    }
    public function register_participant(Request $request)
    {

        $this->validate($request, [
            'dni' => 'required|min:8|alpha_num',
            'firstlastname' => 'required',
            'secondlastname' => 'required',
            'name' => 'required',
            'email' => 'required',
            //'image' => 'mimes:jpeg,jpg,png,gif|required',
        ],
            [
                'dni.required' => 'El campo DNI es obligatorio',
                'dni.min' => 'El campo DNI debe tener como minimo 8 y como maximo 9 digitos si es un pasaporte',
                'dni.alpha_num' => 'El campo DNI debe contener solo letras y numeros',
                'firstlastname.required' => 'El campo apellido paterno es obligatorio',
                'secondlastname.required' => 'El campo apellido materno es obligatorio',
                'name.required' => 'El campo nombre es obligatorio',
                'email.required' => 'El campo correo es obligatorio',
                //'image.required' => 'La imagen es obligatorio',
            ]);

        $user = Auth::user();
        // Recuperamos el rol del suario logueado
        $id_rol = DB::table('role_user')
            ->where('user_id', $user->id)
            ->first()->role_id;
        $id_company = $user->id_company;
        // verificar si el rol es administrador facilitador ellos solo regitran los participantes de company
        if ($id_rol == 1) {
            $id_company = '2';
        }
        // rregister_participantespecto a su unidad minera y dni y rol 5(partcipante)
        $d =  DB::table('users')
            ->join('role_user','users.id','=','role_user.user_id')
            ->join('companies', 'companies.id', 'users.id_company')
            ->where('dni', $request->dni)
            ->where('id_unity', $user->id_unity)
            ->where('role_id',5);

        if ($d->exists()) {
            return redirect()->route('new_participant')
                ->with('error',
                    'El usuario con dni '.
                    $request->dni.'  ya esta registrado en la contrata '.$d->first()->businessName);
        } else {
            // usuario en el q esta loageuado
            $idUser = Auth::user();
            $participant = new User();
            $participant->id_company = $id_company;
            $participant->type_document = $request->type_document;
            $participant->dni = $request->dni;
            $participant->firstlastname = $request->firstlastname;
            $participant->secondlastname = $request->secondlastname;
            $participant->name = $request->name;
            $participant->position = $request->position;
            $participant->phone = $request->phone;
            $participant->email = $request->email;
            $participant->password = bcrypt(md5($request->secondlastname));
            $participant->remember_token = null;
            $participant->code_bloqueo = null;
            $participant->medical_exam = $request->medical_exam;
            $participant->id_management = $request->id_management;
            $participant->superintendence = $request->superintendence;

            //-- Manejar el archivo de la imagen

            /*PENDIENTE */

//            if ($request->hasFile('image')) {
//                // Recuperamos el nombre y extnsion del archivo del archivo
//                $filenameWithExt = $request->file('image')->getClientOriginalName();
//                // recuperamos solo el nombre
//                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
//                // Recuperamos solo la extension
//                $ext = $request->file('image')->getClientOriginalExtension();
//                // Nombre de archivo para alamcenar
//                $filenameToStore = $filename.'_'.time().'_'.$ext;
//                // Upload Image
//                $path = $request->file('image')->storeAs('public/avatar/', $filenameToStore);
//                // dd(storage_path(), $filenameToStore, public_path());
//                // dd($filenameWithExt, $filename,$ext);
//            } else {
//                $filenameToStore = 'noimage.jpg';
//            }

            if ($request->image != "") {
                $name_original = $request->file('image')->getClientOriginalName();
                $name = $request->file('image');
                $name_hash = $name->hashName();
                $name->move('img/', $name_hash);
                $participant->image = $name_original;
                $participant->image_hash = $name_hash;
            }else{
                $participant->image = "";
                $participant->image_hash = "";
            }
            //$participant->image = $filenameToStore;
            //$participant->image_hash = '';
            $participant->birth_date = $request->birth_date;
            $participant->gender = $request->gender;
            $participant->origin = $request->origin;
            $participant->address = $request->address;
            $participant->state = 0;
            $participant->id_user = $idUser->id;
            $participant->id_unity = $idUser->id_unity;

            $participant->save();

            $participant->roles()->sync(5);

            return redirect()->route('list_participants')->with('success','El participante fue registrado');
        }
        /*$name_original = $request->file('image')->getClientOriginalName();
        $name = $request->file('image');
        $name_hash = $name->hashName();
        $name->move('img/', $name_hash);*/



    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }


    public function edit(User $user)
    {
        $companies = Company::pluck('businessName','id');
        $roles = Role::get();
        return view('users.edit',compact('user','roles','companies'));
    }


    public function update(Request $request, User $user)
    {
        //actualizar usuarios
        $user->update($request->all());

        //actualizar roles
        $user->roles()->sync($request->get('roles'));
        return redirect()->route('users.edit', $user->id)->with('info','Usuario actualizado con exito');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('info','Eliminado correctamente');
    }

    public function profile()
    {
        return view('users.profile');
    }
    public function json_list_user()
    {
        $users = DB::table('users')->select('name','email','state')->get();
        return response()->json($users);
    }

    public function list_participants()
    {

        $id_company = Auth::user()->id_company;
        $id_rol = DB::table('role_user')
            ->where('user_id', Auth::user()->id)
            ->first()->role_id;
        if ($id_rol == 1) {
            $id_company = '2';
        }
        $id_unity = Auth::user()->id_unity;
        $idUser = Auth::id();
        $participants = DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->select('users.id as id','dni','firstlastname','secondlastname','name',
                'position', 'superintendence', 'state','id_user')
            ->where('id_company',$id_company)
            ->where('id_unity',$id_unity)
            ->where('role_id',5)
            ->where('users.state', '0')
            ->get();

        return view('participants.index',compact('participants','idUser'));
    }
    public function edit_participants(Request $request)
    {
        $decript = Crypt::decryptString($request->id);
        $users = User::find($decript);
        $managements = Management::pluck('name','id');
        return view('participants.edit',compact('users','managements'));
    }

    public function update_participant(Request $request, $id)
    {
        $user = Auth::user();

        $this->validate($request, [
            'dni' => 'required|min:8|alpha_num',
            'firstlastname' => 'required',
            'secondlastname' => 'required',
            'name' => 'required',
            'email' => 'required',


        ],
            [
                'dni.required' => 'El campo DNI es obligatorio',
                'dni.min' => 'El campo DNI debe tener como minimo 8 y como maximo 9 digitos si es un pasaporte',
                'dni.alpha_num' => 'El campo DNI debe contener solo letras y numeros',
                'firstlastname.required' => 'El campo apellido paterno es obligatorio',
                'secondlastname.required' => 'El campo apellido materno es obligatorio',
                'name.required' => 'El campo nombre es obligatorio',
                'email.required' => 'El campo correo es obligatorio',


            ]);

        $busqueda = DB::table('users')
            ->where('id','=',$id )
            ->where('dni','=',trim($request->dni))
            ->count();

        if($busqueda>0) {

            $user = User::find($id);
            $user->type_document = $request->type_document;
            $user->dni = $request->dni;
            $user->firstlastname = $request->firstlastname;
            $user->secondlastname = $request->secondlastname;
            $user->name = $request->name;
            $user->position = $request->position;
            $user->phone = $request->phone;
            $user->email = $request->email;
            //$user->code_bloqueo = $request->code_bloqueo;
            $user->medical_exam = $request->medical_exam;   
            $user->id_management = $request->id_management;
            $user->superintendence = $request->superintendence;
            if ($request->image != "") {
                $name_original = $request->file('image')->getClientOriginalName();
                $name = $request->file('image');
                $name_hash = $name->hashName();
                $name->move('img/', $name_hash);
                $user->image = $name_original;
                $user->image_hash = $name_hash;
            }else{
                $user->image = $user->image;
                $user->image_hash = $user->image_hash;
            } 
            $user->birth_date = $request->birth_date;
            $user->gender = $request->gender;
            $user->origin = $request->origin;
            $user->address = $request->address;
            $user->save();

            return redirect()->route('list_participants')->with('success','El participante fue actualizado');


        } else {

            $d = DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('companies', 'companies.id', 'users.id_company')
                ->where('dni', $request->dni)
                ->where('id_unity', $user->id_unity)
                ->where('role_id', 5);

            if ($d->exists()) {
                return redirect()->route('list_participants')->with('error',
                    'El usuario con dni ' .
                    $request->dni . '  ya esta registrado en la contrata ' . $d->first()->businessName);

            } else {

                $user = User::find($id);
                $user->type_document = $request->type_document;
                $user->dni = $request->dni;
                $user->firstlastname = $request->firstlastname;
                $user->secondlastname = $request->secondlastname;
                $user->name = $request->name;
                $user->position = $request->position;
                $user->phone = $request->phone;
                $user->email = $request->email;
                $user->code_bloqueo = $request->code_bloqueo;
                $user->medical_exam = $request->medical_exam;
                $user->id_management = $request->id_management;
                $user->superintendence = $request->superintendence;
                if ($request->image != "") {
                    $name_original = $request->file('image')->getClientOriginalName();
                    $name = $request->file('image');
                    $name_hash = $name->hashName();
                    $name->move('img/', $name_hash);
                    $user->image = $name_original;
                    $user->image_hash = $name_hash;
                }
                $user->birth_date = $request->birth_date;
                $user->gender = $request->gender;
                $user->origin = $request->origin;
                $user->address = $request->address;
                $user->save();

                return redirect()->route('list_participants')->with('success', 'El participante fue actualizado');
            }
        }

        /*$this->validate($request, [
            'dni' => 'required',
            'firstlastname' => 'required',
            'secondlastname' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',

        ],
        [
            'dni.required' => 'El campo DNI es obligatorio',
            'firstlastname.required' => 'El campo apellido paterno es obligatorio',
            'secondlastname.required' => 'El campo apellido materno es obligatorio',
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo correo es obligatorio',
            'phone.required' => 'El campo celular es obligatorio',

        ]);

        $user = User::find($id);
        $user->type_document = $request->type_document;
        $user->dni = $request->dni;
        $user->firstlastname = $request->firstlastname;
        $user->secondlastname = $request->secondlastname;
        $user->name = $request->name;
        $user->position = $request->position;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->code_bloqueo = $request->code_bloqueo;
        $user->medical_exam = $request->medical_exam;
        $user->id_management = $request->id_management;
        $user->superintendence = $request->superintendence;
        if ($request->image != "") {
            $name_original = $request->file('image')->getClientOriginalName();
            $name = $request->file('image');
            $name_hash = $name->hashName();
            $name->move('img/', $name_hash);
            $user->image = $name_original;
            $user->image_hash = $name_hash;
        }
        $user->birth_date = $request->birth_date;
        $user->gender = $request->gender;
        $user->origin = $request->origin;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('list_participants')->with('success','El participante fue actualizado');*/

    }
    public function new_participant()
    {
        $managements = Management::pluck('name','id');
        return view('participants.create',compact('managements'));
    }
    public function get_id_company()
    {
        $idUser = Auth::id();
        $id_company =  DB::table('companies')
            ->join('users','companies.id','=','users.id_company')
            ->where('users.id',$idUser)
            ->select('companies.id as ID')->first()->ID;
        return $id_company;
    }
    public function validate_participant()
    {
        return view('participants.validate_participant');
    }

    public function detail_history($dni)
    {
        $histories = DB::table('historico')
            ->where('dni',$dni)
            ->select(DB::raw('origen as nameLocation,id_curso,curso as nameCourses,empresa as businessName,fecha as fecha,nota,asistencia,participante,dni'))
            ->orderBy('fecha','desc')
            ->get();

        $data_generals = DB::table('companies')
            ->join('users','companies.id','=','users.id_company')
            ->join('role_user','users.id','=','role_user.user_id')
            ->join('user_inscriptions','user_inscriptions.id_user','=','users.id')
            ->join('inscriptions','inscriptions.id','=','user_inscriptions.id_inscription')
            ->join('courses','courses.id','=','inscriptions.id_course')
            ->join('locations','locations.id','=','inscriptions.id_location')
            ->select(DB::raw('locations.name as nameLocation,courses.id as id_curso,courses.name as nameCourses,companies.businessName as businessName,inscriptions.startDate as fecha,point as nota,assistence as asistencia,CONCAT(users.name," ",users.firstlastname," ",users.secondlastname) AS participante,users.dni as dni'))
            ->where('dni',$dni)
            ->where('inscriptions.startDate','<',date('Y-m-d'))
            ->where('role_id',5)
            ->orderBy('inscriptions.startDate','desc')
            ->get();


        $merged = $data_generals->merge($histories);
        return view('participants.detail_validate_user',compact('merged'));
    }

    public function export($id)
    {
        $inscriptions =  DB::table('inscriptions')
            ->join('locations','inscriptions.id_location','=','locations.id')
            ->join('courses','inscriptions.id_course','=','courses.id')
            ->select('inscriptions.id as id','courses.name as nameCourse','locations.name as nameLocation','startDate','endDate','address','time','slot','inscriptions.state as state')
            ->where('inscriptions.id',$id)
            ->get()->toArray();

        $facilitador = DB::table('user_inscriptions')
            ->join('users','users.id','=','user_inscriptions.id_user')
            ->join('role_user','users.id','=','role_user.user_id')
            ->where('role_id',3)
            ->where('user_inscriptions.id_inscription',$id)
            ->select(DB::raw('CONCAT(name, " ", firstlastname, " ",secondlastname) AS full_name'))
            ->first()->full_name;

        $participants = DB::table('user_inscriptions')
            ->join('users','users.id','=','user_inscriptions.id_user')
            ->join('role_user','users.id','=','role_user.user_id')
            ->join('companies','companies.id','=','users.id_company')
            ->where('role_id',5)
            ->where('user_inscriptions.id_inscription',$id)
            ->get();

        $customer_array[] = array('DNI','AP.PATERNO', 'AP.MATERNO','NOMBRES','EMPRESA','SUBCONTRATA','CARGO');
        foreach ($participants as $participant) {
            $customer_array[] = array(
                'DNI'           =>  $participant->dni,
                'AP.PATERNO'      =>  $participant->firstlastname,
                'AP.MATERNO'      =>  $participant->secondlastname,
                'NOMBRES'       =>  $participant->name,
                'EMPRESA'       =>  $participant->businessName,
                'SUBCONTRATA'   =>  $participant->subcontrata,
                'CARGO'         =>  $participant->position,
            );
        }

        $customer_head[] = array('FECHA','CURSO','LUGAR', 'DIRECCION','FACILITADOR');
        foreach ($inscriptions as $inscription) {
            $customer_head[] = array(
                'FECHA'         => $inscription->startDate,
                'CURSO'         => $inscription->nameCourse,
                'LUGAR'         => $inscription->nameLocation,
                'DIRECCION'     => $inscription->address,
                //'FACILITADOR'   => $facilitador[0]->full_name,   
            );
        }

        Excel::create('Lista participantes', function($excel) use($customer_array,$customer_head){
            $excel->setTitle('MMG Data');
            $excel->sheet('MMG Data', function($sheet) use ($customer_array,$customer_head){
                $sheet->row(1, ["LISTA DE PARTICIPANTES"]);
                $sheet->mergeCells('A1:G1');

                $sheet->fromArray($customer_head, null, 'A2', false, false);

                $sheet->fromArray($customer_array, null, 'A5', false, false);
                $sheet->cells('A1:G50', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '13',
                        'bold'       =>  true,
                        'color'     => '#ffffff',
                    ));
                });
            });
        })->download('xlsx');
    }
//    public function json_list_fys()
//    {
//        $dni = $request->dni;
//        $historicos = DB::table('historico')->where('dni',$dni)->orderBy('fecha','desc')->get();
//        return response()->json($historicos);
//    }
    public function search_participant (Request $request) {
        $user = Auth::user();
        $dni = $request->dni;
        $users = DB::table('users')
            ->select('users.id as id', 'users.id_unity', 'users.id_company', 'users.state',
                'users.dni', 'users.firstlastname', 'users.secondlastname', 'users.name',
                'companies.businessName as empresa','users.phone','users.superintendence')
            ->join('role_user','role_user.user_id', '=', 'users.id')
            ->join('companies', 'companies.id', '=', 'users.id_company')
            ->where('id_unity', $user->id_unity)
            ->where('role_id', 5)
            ->where('users.dni', 'like', '%'.$dni.'%')
            ->get();
        return view('participants.search',compact('users'));
    }

    public  function detail_participant (Request $request) {
        
        $user = User::query()
            ->select('users.id as id', 'dni',
                'firstlastname', 'secondlastname', 'name',
                'position', 'superintendence', 'businessName','image','image_hash','users.phone','users.superintendence')
            ->join('companies', 'companies.id', '=', 'users.id_company')
            ->where('users.id', $request->id)
            ->first();

        $result = DB::table('user_inscriptions')
            ->select(
                'user_inscriptions.id as id', 'user_inscriptions.point', 'user_inscriptions.state',
                'nameCurso as course','inscriptions.id_course as id_course', 'startDate as date',
                DB::raw('IF(user_inscriptions.point >= inscriptions.point_min, 1,0) as aprobado'),
                DB::raw('
        IF(user_inscriptions.point >= inscriptions.point_min,
            IF(inscriptions.type_validaty = 1, 
                DATE_ADD(inscriptions.startDate, INTERVAL inscriptions.validaty DAY),
                IF(inscriptions.type_validaty = 2, 
                    DATE_ADD(inscriptions.startDate, INTERVAL inscriptions.validaty MONTH),
                    IF(inscriptions.type_validaty = 3,DATE_ADD(inscriptions.startDate, INTERVAL inscriptions.validaty YEAR),0)
                    ) 
                ),
            0) as vigencia'
                )
            )
            ->join('inscriptions','inscriptions.id', '=', 'user_inscriptions.id_inscription')
            ->where('user_inscriptions.id_user',$user->id)
            ->whereIn('user_inscriptions.state', [0,1])
            ->get();
       
        return view('participants.detail_participant', compact('user', 'result'));
    }

    public function upload_participant() {
        return view('participants.create_file');
    }

    public  function upload_participant_validate(Request $request) {
        ini_set('max_execution_time', '300');
        ini_set('max_input_time', '300');
        $user = Auth::user();
        $error = [];
        $count_insert = 0;
        $count_update = 0;

        Excel::load($request->file_up, function ($reader) use($request, $user, &$error, &$count_insert, &$count_update) {

            $a = 0;
            $i = 0;
            $u = 0;
            $e = [];
            $id_company = $user->id_company;
            $id_unity = $user->id_unity;
            $id_rol = DB::table('role_user')
                ->where('user_id', $user->id)
                ->first()->role_id;
            if ($id_rol == 1) {
                $id_company = '2';
            }

            $results = $reader->get();
            $results->each(function ($row) use($user, &$e, &$i, &$u, &$a, $id_company, $id_unity, $id_rol) {
                $doc = trim($row->dni);

                if (strlen($doc) >= 8){
                    $participante = User::updateOrCreate(
                        [
                            'dni' => $doc,
                            'id_unity' => $id_unity,
                        ],
                        [
                            'id_company' => $id_company,
                            'firstlastname' => $row->ap_paterno,
                            'secondlastname' => $row->ap_materno,
                            'name' => $row->nombre,
                            'type_document' => 0,
                            'email' => 'mai@mail.com',
                            'password' => bcrypt(md5($row->ap_paterno)),
                            'position' => $row->cargo,
                            'superintendence' => $row->area,
                            'state' => 0,
                            'id_user' => $user->id,
                        ]
                    );
                    if ($participante->wasRecentlyCreated) {
                        $i++;
                        $participante->roles()->sync(5);
                    } else {
                        $u++;
                    }
                } else {
                    // Mostrr el error de dni
                    array_push($e, $doc);
                }
                $a++;
            });
            $count_insert = $i;
            $count_update = $u;
            $error = $e;
        });

        return redirect()->route('list_participants')
            ->with('success','fueron registrados: '.$count_insert.' particpantes y fueron actualizados: '.$count_update.' participantes')
            ->with('error', 'los siguientes dni(s) son incorretos: '.json_encode($error));
    }

    public function company_participant(Request $request)
    {
        $query = [];
        $mensaje = 'Ingrese el dni del participante';
        if ($request->method() === 'POST')
        {
            $user = Auth::user();
            $dni = $request->dni;
            $query = DB::table('users')
                ->select('users.id', 'users.id_unity', 'users.id_company', 'users.state',
                    'users.dni', 'users.firstlastname', 'users.secondlastname', 'users.name',
                    'companies.businessName as empresa')
                ->join('role_user','role_user.user_id', '=', 'users.id')
                ->join('companies', 'companies.id', '=', 'users.id_company')
                ->where('id_unity', $user->id_unity)
                ->where('role_id', 5)
                ->where('users.dni', '=', $dni)
                ->get();
            //dd($query->count());
            if ($query->count() === 0)
            {
                $mensaje = 'El Documento del participante no existe.';
            }
        }
        return view('users.company_partcipant', compact('query', 'mensaje'));
    }

    public function changeCompany(Request $request, $id) {

        $message = '';
        if ($request->ajax())
        {
            $contrata = Auth::user();
            $user = DB::table('users')
                ->where('id', $request->id);

            $user->update(['state' => 0, 'id_company' => $contrata->id_company]);
            $id_company = $user->first()->id_company;
            $company = Company::find($id_company);
            $message = 'El participante fue cambiado correctamente de empresa';

            return response()->json([
                'name' => $company->businessName,
                'message' => $message
            ]);
        }
        return $message;
    }

    public function desactivateUser(Request $request, $id) {

        $message = '';
        if ($request->ajax())
        {
            $user = DB::table('users')
                ->where('id', $request->id);

            $user->update(['state' => 1]);
            $message = 'El participante fue desactivado correctamente';

            return response()->json([
                'message' => $message
            ]);
        }
        return $message;
    }

    public function editUserCompany (Request $request) {
        $user = User::findOrFail($request->id);
        $company = Company::findOrFail($user);
        // dd($company);

        return view('companies.user_company',compact('user', 'company'));
    }

    public function updateUserCompany (Request $request, $id)
    {

        $this->validate($request, [
            'dni' => 'required|alpha_num',
            'firstlastname' => 'required',
            'secondlastname' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ],
            [
                'dni.required' => 'El campo DNI es obligatorio',
                'dni.alpha_num' => 'El campo DNI solo debe contener letras y números',
                'firstlastname.required' => 'El campo apellido paterno es obligatorio',
                'secondlastname.required' => 'El campo apellido materno es obligatorio',
                'name.required' => 'El campo nombre es obligatorio',
                'email.required' => 'El campo correo electronico es obligatorio',
                'phone.required' => 'El campo celular es obligatorio',
            ]);

        // dd($request);

        $userAuth = Auth::id();
        $user = User::find($id);
        $user->type_document = $request->type_document;
        $user->dni = strtoupper(trim($request->dni));
        $user->firstlastname = strtoupper(trim($request->firstlastname));
        $user->secondlastname = strtoupper(trim($request->secondlastname));
        $user->name = trim($request->name);
        $user->email_valorization = trim($request->email_valorization);
        $user->phone = trim($request->phone);

        // dd($user);

        // $user->email = $request->email;
        // $user->code_bloqueo = $request->code_bloqueo;
        // $user->medical_exam = $request->medical_exam;
        //$user->id_management = $request->id_management;
        //$user->superintendence = $request->superintendence;
//        if ($request->image != "") {
//            $name_original = $request->file('image')->getClientOriginalName();
//            $name = $request->file('image');
//            $name_hash = $name->hashName();
//            $name->move('img/', $name_hash);
//            $user->image = $name_original;
//            $user->image_hash = $name_hash;
//        }
        // $user->birth_date = $request->birth_date;
        // $user->gender = $request->gender;
        // $user->origin = $request->origin;
        // $user->address = $request->address;
        $user->save();

        $view = 'companies.index';
        if ($user->id === $userAuth) {
            $view = 'home';
        }
        $company = Company::where('id', $user->id_company)->first();
        return redirect()->route($view)
            ->with(
                'success',
                'Se a actualizado satisfactoriamente el USUARIO: '.  $user->email . ' de la EMPRESA: ' . $company->businessName
            );
    }
}
