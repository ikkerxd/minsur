<?php

namespace App\Http\Controllers;

use App\Inscription;
use App\Location;
use App\Course;
use App\Recuperation;
use App\TypeCourse;
use App\Participant;
use App\UserInscription;
use App\Historico;
use App\Company;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Custom\WebServiceManagerCurl;
use GuzzleHttp\Client;
use Excel;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;

class InscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:inscriptions.create')->only(['create', 'store']);
        $this->middleware('permission:inscriptions.index')->only('index');
        $this->middleware('permission:inscriptions.edit')->only(['edit', 'update']);
        $this->middleware('permission:inscriptions.show')->only('show');
        $this->middleware('permission:inscriptions.destroy')->only('destroy');
    }

    /* === link /inscriptions principal ===*/
    public function index()
    {
        $user = Auth::user();
        $inscriptions =  DB::table('inscriptions')
            ->select('inscriptions.id as id','inscriptions.nameCurso','locations.name as nameLocation',
                'startDate','address','time', 'inscriptions.id_course')
            ->join('locations','inscriptions.id_location','=','locations.id')
            ->join('courses', 'courses.id', '=', 'inscriptions.id_course')
            ->where('startDate','>',date('2019-03-01'))
            ->where('courses.id_unity', $user->id_unity)
            ->orderBy('startDate','asc')
            ->where('type',0)
            ->get();

        return view('inscriptions.index',compact('inscriptions'));
    }

    public function create()
    {
        $user = Auth::user();
        $locations = Location::pluck('name','id');  
        $courses = Course::where('id_unity', $user->id_unity)->pluck('name','id');
        $users = DB::table('users')
            ->join('role_user','users.id','=','role_user.user_id')
            ->select(DB::raw('CONCAT(name, " ", firstlastname, " ",secondlastname) AS full_name, users.id AS id'))
            ->whereIn('role_id', [1, 3])
            ->pluck('full_name', 'id');
        return view('inscriptions.create',compact('locations','courses','users'));
    }

    public function store(Request $request)
    {        
        // $nota = '<p><b>Indicaciones para el día de realización del curso:</b></p><p></p><ol><li>El participante debe presentarse 20 minutos antes del inicio del curso.</li><li>El participante debe acudir con su DNI y/o Pasaporte(vigente).</li><li>Una vez que el participante ingresa al aula no se otorgan permisos de ausencia.</li><li>El participante deberá asistir al 100% del dictado del curso y aprobar el examen para obtener su Anexo 4.</li><li>Si el participante desaprueba la evaluación final, se deberá realizar una nueva inscripción y pago.</li><li>NO podrán ingresar al aula vistiendo short, bermudas, gorras ó lentes de sol.</li></ol><p></p>';

        $course = DB::table('courses')
            ->where('id', $request->id_course)
            ->get()[0];

        $inscription = new Inscription;
        $inscription->id_course = $request->id_course;
        $inscription->id_location = $request->id_location;       
        $inscription->startDate = $request->startDate;       
        $inscription->endDate = $request->startDate;
        $inscription->address = $request->address;       
        $inscription->time = $request->time;
        $inscription->slot = 100; // defecto
        $inscription->id_user = $request->id_user;
        $inscription->nameCurso = $course->name;
        $inscription->price = $course->price;
        $inscription->hours = $course->hh;
        $inscription->validaty = $course->validaty;
        $inscription->point_min = $course->point_min;
        // $inscription->slot = $request->slot;
        $inscription->note = 'sin notas';
        $inscription->type = 0;               
        $inscription->state = 0;
        $inscription->save();

        return redirect()->route('inscriptions.index')->with('success','La inscripcion fue registrada');
    }

    public function show($id)
    {        
        $inscription =  DB::table('inscriptions')
            ->select('inscriptions.id as id',
                'id_course', 'nameCurso','locations.name as nameLocation',
                'startDate','inscriptions.address','time','slot','inscriptions.state as state','hours',
                'users.firstlastname as firstName', 'users.name as nameUser')
            ->where('inscriptions.id',$id)
            ->join('locations','inscriptions.id_location','=','locations.id')
            ->join('users', 'users.id', '=', 'inscriptions.id_user')
            ->first();

        if ($inscription->id_course  == 8) {
            $participants = DB::table('user_inscriptions')
                ->select(
                    'user_inscriptions.id as id',
                    'U.dni','U.firstlastname','U.secondlastname', 'U.name','C.businessName',
                    'user_inscriptions.state as state',
                    'user_inscriptions.point',
                    DB::raw('IF(recuperations.point, recuperations.point ,user_inscriptions.point) as point'),
                    DB::raw('IF(recuperations.point, user_inscriptions.point, NULL) as sustitutorio'),
                    'CP.businessName as previous_company'
                )
                ->join('users AS U','U.id','=','user_inscriptions.id_user')
                ->join('companies as C','C.id','=','U.id_company')
                ->join('users as UC','UC.id','=','user_inscriptions.id_user_inscription')
                ->join('companies as CP','CP.id','=','UC.id_company')
                ->leftJoin('recuperations', 'recuperations.id_user_inscription', '=', 'user_inscriptions.id')
                ->where('user_inscriptions.state','<>',2)
                ->where('user_inscriptions.id_inscription',$id)
                ->orderby('user_inscriptions.id')
                ->get();
        } else {
            $participants = DB::table('user_inscriptions')
                ->select('user_inscriptions.id as id',
                    'U.dni','U.firstlastname','U.secondlastname', 'U.name','C.businessName',
                    'user_inscriptions.state as state','user_inscriptions.point',
                    'CP.businessName as previous_company')
                ->join('users AS U','U.id','=','user_inscriptions.id_user')
                ->join('companies as C','C.id','=','U.id_company')
                ->join('users as UC','UC.id','=','user_inscriptions.id_user_inscription')
                ->join('companies as CP','CP.id','=','UC.id_company')
                ->where('user_inscriptions.state','<>',2)
                ->where('user_inscriptions.id_inscription',$id)
                ->get();
        }


        return view('inscriptions.show',compact('inscription','participants'));
    }

    
    public function edit(Inscription $inscription)
    {
        $user = Auth::user();
        $locations = Location::pluck('name','id');
        $courses = Course::where('id_unity', $user->id_unity)->pluck('name','id');
        $users = DB::table('users')
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->select(DB::raw('CONCAT(name, " ", firstlastname, " ",secondlastname) AS full_name, users.id AS id'))
                        ->whereIn('role_id', [1, 3])
                        ->pluck('full_name', 'id');
        return view('inscriptions.edit',compact('inscription','locations','courses','users'));
    }

    public function update(Request $request, $id)
    {
        $course = DB::table('courses')
            ->where('id', $request->id_course)
            ->get()[0];

        $inscription = Inscription::find($id);
        $inscription->id_course = $request->id_course;       
        $inscription->id_location = $request->id_location;
        $inscription->id_user = $request->id_user;
        $inscription->startDate = $request->startDate;
        $inscription->endDate = $request->startDate;
        $inscription->address = $request->address;       
        $inscription->time = $request->time;       
        $inscription->slot = 100;
        $inscription->note = 'sin notas';
        $inscription->nameCurso = $course->name;
        $inscription->price = $course->price;
        $inscription->hours = $course->hh;
        $inscription->validaty = $course->validaty;
        $inscription->point_min = $course->point_min;
        $inscription->save();

        return redirect()->route('inscriptions.index')->with('success','La inscripción fue actualizada');
    }

    
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {            
            $inscription = \App\Inscription::find($id);
            $inscription->delete();  
            return response()->json([                
                'success'   => $inscription->name.' fue eliminado.',
            ]);          
        }
    }

    public function user_inscription()
    {
        $user = Auth::user();
        $type_courses = DB::table('type_courses')->where('id_unity','=',$user->id_unity)->get()->toArray();
        $locations = DB::table('locations')->get()->toArray();
        $inscriptions =  DB::table('inscriptions')
            ->join('locations','inscriptions.id_location','=','locations.id')
            ->join('courses','inscriptions.id_course','=','courses.id')
            ->select('inscriptions.id as id',
                'courses.name as nameCourse',
                'locations.name as nameLocation',
                'startDate',
                'endDate',
                'address',
                'time','slot','inscriptions.state as state')
            ->get();
        return view('inscriptions.inscription',compact('inscriptions','type_courses', 'locations'));
    }

    public function json_inscription(Request $request)
    {
        $idLocation = $request->idLocation;
        $idTypeCourse = $request->idTypeCourse;
        $dt = date('Y-m-d', time() - 60*60*0);

        $inscriptions =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')
                        ->join('courses','inscriptions.id_course','=','courses.id')
                        ->join('type_courses','type_courses.id','=','courses.id_type_course')
                        ->select('inscriptions.id as id',
                            'inscriptions.nameCurso as nameCourse',
                            'locations.name as nameLocation',
                            'inscriptions.startDate',
                            'inscriptions.endDate',
                            'inscriptions.address',
                            'inscriptions.time',
                            'inscriptions.slot','inscriptions.state as state','inscriptions.price','inscriptions.hours','minimum')
                        ->where('type_courses.id',$idTypeCourse)
                        ->where('id_location',$idLocation)
                        ->where('startDate','>=',$dt)
            ->orderBy('startDate','asc')
                        ->get();
        return response()->json($inscriptions);
    }

    public function userInscription($id)
    {
        $idUser = Auth::id();
        $user = Auth::user();
        $id_company = $user->id_company;
        $id_rol = DB::table('role_user')
                    ->where('user_id', $idUser)
                    ->first()->role_id;

        if ($id_rol == 1) {
            $id_company = 2;
        }

        $businessName = DB::table('companies')
                         ->join('users','users.id_company','=','companies.id')
                         ->where('users.id',$idUser)
                         ->select('businessName')->first()->businessName;

        // datos de la inscripcion
        $inscriptions =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')    
                        ->join('courses','inscriptions.id_course','=','courses.id')
                        ->select('inscriptions.id as id','courses.name as nameCourse','locations.name as nameLocation', 'locations.id as idLocaltion','startDate','address','slot','hh','time','minimum')
                        ->where('inscriptions.id',$id)
                        ->get();
        //participantes inscritos
        $parts_insc = DB::table('user_inscriptions')
                        ->select('id_user')
                        ->where('id_inscription',$id)
                        ->where('id_user_inscription',$user->id)
                        ->whereIn('state',[0,1]);
        // numero de paticpntes incritos por el momento de acuerdo al  contrata
        $count_part = $parts_insc->count();
        // id de prticpants
        $list_part = $parts_insc->get();
        $ids_part = [];
        foreach ($list_part as $part) {
            array_push($ids_part, $part->id_user);
        }
        // Lista de partcipntes q no estan inscritos
        $participants = DB::table('users')
                        ->select('users.id as id','dni', 'firstlastname','secondlastname','name',
                            'position','superintendence', 'users.state')
                        ->join('role_user','role_user.user_id','=','users.id')
                        ->where('id_unity', $user->id_unity)
                        ->where('id_company',$id_company)
                        ->where('role_id',5)
                        ->where('users.state','='. 0)
                        ->whereNotIn('users.id', $ids_part)
                        ->orderBy('firstlastname', 'ASC')
                        ->get();

        return view('inscriptions.register',
            compact('inscriptions','idUser','id','businessName','participants', 'count_part'));
    } 

    public function details()
    {
        $idUser = Auth::id();
        $dt = date('Y-m-d');
        $inscriptions = DB::table('user_inscriptions')
                        ->select(
                            'user_inscriptions.id_inscription',
                            'inscriptions.startDate',
                            'inscriptions.nameCurso', 'locations.name', 'inscriptions.state')
                        ->distinct()
                        ->join('inscriptions', 'inscriptions.id', '=', 'user_inscriptions.id_inscription')
                        ->join('locations', 'locations.id', '=', 'inscriptions.id_location')
                        ->where('id_user_inscription', $idUser)
                        ->where('inscriptions.startDate', '>=', $dt)
                        ->get();

        return view('inscriptions.details',compact('inscriptions'));
    }

    public function details_id($id)
    {        
        $idUser = Auth::id();
        $inscriptions =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')    
                        ->join('courses','inscriptions.id_course','=','courses.id')
                        ->join('user_inscriptions','inscriptions.id','=','user_inscriptions.id_inscription')                        
                        ->select('user_inscriptions.id as id','locations.name as nameLocation','courses.name as nameCourse','startDate','time','note','address')
                        ->where('id_user',$idUser)                        
                        ->where('user_inscriptions.id',$id)
                        ->get();
        $participants = DB::table('users')
                        ->join('user_inscriptions','users.id','=','user_inscriptions.id_user')        
                        // ->select('user_inscriptions.id as id','locations.name as nameLocation','courses.name as nameCourse','startDate','time','note','address')
                        ->where('user_inscriptions.id',$id)                        
                        ->get();
        $participants = DB::table('participants')->where('id_user_inscription',$id)->where('state','!=',2)->get();
        
        return view('inscriptions.details_users');
    }

    public function inscription_participants($id)
    {
        //$decrypted = Crypt::decryptString($id);
        //$participants = DB::table('participants')->where('id_user_inscription',$decrypted)->get();

        //$participants = DB::table('participants')->where('id_user_inscription',$id)->get();        
        return view('inscriptions.register_participants',compact('participants','id'));
    }
    public function buscar_dni($dni)
    {
        $client = new Client(['base_uri' => 'https://api.reniec.cloud','timeout'  => 2.0,]);        
        $response = $client->request('GET', "dni/{$dni}", ['verify' => false]);
        //$response = $client->request('GET', "dni/{$dni}");
        $result = json_decode($response->getBody()->getContents());
        return response()->json($result);
    }
    public function reschedule(Request $request)
    {
        $id_user_inscription = $request->input('id');
        
        $participants = DB::table('participants')
                        ->where('id_user_inscription',$id_user_inscription)
                        ->where('state','!=',2)
                        ->get();

        $type_courses = TypeCourse::all();
        $locations = Location::all();
        $inscriptions =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')    
                        ->join('courses','inscriptions.id_course','=','courses.id')                    
                        ->select('inscriptions.id as id','courses.name as nameCourse','locations.name as nameLocation','startDate','endDate','address','time','slot','inscriptions.state as state')->get();

        return view('inscriptions.reschedule',compact('inscriptions','participants','id_user_inscription','type_courses','locations'));
    }

    public function cancel(Request $request)
    {
        $id_user_inscription = $request->input('id');
        
        $participants = DB::table('participants')->where('id_user_inscription',$id_user_inscription)->where('state','!=',2)->get();

        $type_courses = TypeCourse::all();
        $locations = Location::all();
        $inscriptions =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')    
                        ->join('courses','inscriptions.id_course','=','courses.id')                    
                        ->select('inscriptions.id as id','courses.name as nameCourse','locations.name as nameLocation','startDate','endDate','address','time','slot','inscriptions.state as state')->get();

        return view('inscriptions.cancel',compact('inscriptions','participants','id_user_inscription','type_courses','locations'));
    }
    public function detail_inscription($id)
    {
         $inscription =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')    
                        ->join('courses','inscriptions.id_course','=','courses.id')                    
                        ->select('inscriptions.id as id','courses.name as nameCourse','locations.name as nameLocation','startDate','endDate','address','time','slot','inscriptions.state as state')
                        ->where('inscriptions.id',$id)
                        ->get();

        $detail_inscriptions =  DB::table('inscriptions')
                        ->join('user_inscriptions','inscriptions.id','=','user_inscriptions.id_inscription')   
                        ->join('users','users.id','=','user_inscriptions.id_user')                    
                        ->join('companies','companies.id','=','users.id_company')                    
                        ->select('ruc','businessName','voucher','voucher_hash')
                        ->where('inscriptions.id',$id)
                        ->get();
        return view('inscriptions.detail_inscriptions',compact('detail_inscriptions','inscription'));
    }

    public function detail_inscription_contrata($id)
    {
        $user = Auth::user();
        $id_company = $user->id_company;
        $id_rol = DB::table('role_user')
            ->where('user_id', $user->id)
            ->first()->role_id;

        if ($id_rol == 1) {
            $id_company = 2;
        }
        $inscriptions =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')
                        ->select('inscriptions.id as id',
                            'nameCurso',
                            'locations.name as nameLocation',
                            'startDate','address',
                            'time',
                            'inscriptions.state as state')
                        ->where('inscriptions.id',$id)
                        ->get();
        
        $participants = DB::table('users')
                        ->join('user_inscriptions','users.id','=','user_inscriptions.id_user') 
                        ->select('users.id as id',
                            'dni','firstlastname','secondlastname','name',
                            'position','subcontrata','user_inscriptions.state',
                            'user_inscriptions.id as id_user_inscription')
                        ->where('user_inscriptions.id_inscription', $id)
                        ->where('users.id_company', $id_company)
//                        ->where(function ($query) use ($id) {
//                            $query->where('id_user_inscription','=',$id)
//                                    ->where('user_inscriptions.state','=','0');
//                        })
//                        ->orWhere(function ($query) use ($id) {
//                            $query->where('id_user_inscription','=',$id)
//                                ->where('user_inscriptions.state','=','1');
//                        })
                        ->get();
        
        return view('inscriptions.details_users',compact('inscriptions','id','participants'));
    }

    public function register_point($id)
    {
        $inscription =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')    
                        ->join('courses','inscriptions.id_course','=','courses.id')                    
                        ->select('inscriptions.id as id','courses.name as nameCourse','locations.name as nameLocation','startDate','endDate','address','time','slot','inscriptions.state as state','hh')
                        ->where('inscriptions.id',$id)
                        ->get();

        $facilitador = DB::table('user_inscriptions')
                        ->join('users','users.id','=','user_inscriptions.id_user')    
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->where('role_id',3)
                        ->where('user_inscriptions.id_inscription',$id)
                        ->select(DB::raw('CONCAT(name, " ", firstlastname, " ",secondlastname) AS full_name'))
                        ->get();

                        
        $participants = DB::table('user_inscriptions')
                        ->join('users','users.id','=','user_inscriptions.id_user')    
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->join('companies','companies.id','=','users.id_company')
                        ->select('user_inscriptions.id as id','firstlastname','secondlastname','name','assistence','point','obs','dni')
                        ->where('role_id',5)
                        ->where('user_inscriptions.id_inscription',$id)
                        ->where('users.id','<>',179)
                        ->where('user_inscriptions.state','<>',2)
                        ->orderBy('firstlastname','asc')
                        ->get();
                        
        return view('inscriptions.register_point',compact('inscription','facilitador','participants'));
    }
    public function update_point(Request $request){

        foreach ($request->id_user_inscription as $key => $value) {
            $data = array(
                'assistence'    => $request->input('assistence')[$key],
                'point'         => $request->input('point')[$key],
                'obs'           => $request->input('obs')[$key],
            );
            $id_user_inscription = $request->input('id_user_inscription')[$key];            
            UserInscription::whereId($id_user_inscription)->update($data);
        }  
        return redirect()->route('register_point',$request->id_inscription)->with('success','Las notas y asistencia fueron actualizadas');
    }
    public function medical_center(){

        $inscriptions =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')    
                        ->join('courses','inscriptions.id_course','=','courses.id')
                        ->select('inscriptions.id as id','courses.name as nameCourse','locations.name as nameLocation','startDate','endDate','address','time','slot','inscriptions.state as state','inscriptions.type as type')
                        ->where('type',0)
                        ->where('startDate','>',date('2019-03-01'))
                        ->orderBy('startDate','asc')
                        ->get();

        return view('inscriptions.medical_center',compact('inscriptions'));
    }
    public function json_list_prom_curso()
    {
        $inscriptions =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')    
                        ->join('courses','inscriptions.id_course','=','courses.id')
                        ->select('inscriptions.id as id','courses.name as nameCourse','locations.name as nameLocation','startDate','endDate','address','time','slot','inscriptions.state as state','inscriptions.type as type')
                        ->where('type',0)
                        ->where('startDate','>',date('2019-03-01'))
                        ->orderBy('startDate','asc')
                        ->get();
        return Datatables::of($inscriptions)->make(true);
    }

    public function register_participants($id)
    {
        $id = Crypt::decryptString($id);
        $inscription =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')    
                        ->join('courses','inscriptions.id_course','=','courses.id')                    
                        ->select('inscriptions.id as id','courses.name as nameCourse','locations.name as nameLocation','startDate','endDate','address','time','slot','inscriptions.state as state','hh')
                        ->where('inscriptions.id',$id)
                        ->get();

        $facilitador = DB::table('user_inscriptions')
                        ->join('users','users.id','=','user_inscriptions.id_user')    
                        ->join('role_user','users.id','=','role_user.user_id')
                        ->where('role_id',3)
                        ->where('user_inscriptions.id_inscription',$id)
                        ->select(DB::raw('CONCAT(name, " ", firstlastname, " ",secondlastname) AS full_name'))
                        ->get();

        return view('inscriptions.upload_participants',compact('inscription','facilitador'));
    }
    public function centroMedico()
    {
        $inscriptions =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')    
                        ->join('courses','inscriptions.id_course','=','courses.id')
                        ->join('user_inscriptions','user_inscriptions.id_inscription','=','inscriptions.id')
                        ->select('inscriptions.id as id','courses.name as nameCourse','locations.name as nameLocation','startDate','endDate','address','time','slot','inscriptions.state as state','inscriptions.type as type')
                        ->where('type',0)
                        ->where('user_inscriptions.id_user',552)
                        ->orderBy('startDate','desc')
                        ->get();
        return view('centromedico.index',compact('inscriptions'));
    }
    public function createInscription()
    {
        $locations = Location::pluck('name','id');  
        $courses = Course::where('id',10)->pluck('name','id');
        return view('CentroMedico.create',compact('locations','courses'));
    }
    public function save_cm(Request $request)
    {
        $inscription = new Inscription;
        $inscription->id_course = $request->id_course;       
        $inscription->id_location = $request->id_location;       
        $inscription->startDate = $request->startDate;       
        $inscription->endDate = $request->endDate;       
        $inscription->address = $request->address;       
        $inscription->time = $request->time;       
        $inscription->slot = 0;       
        $inscription->note = "";       
        $inscription->type = 0;               
        $inscription->state = 0;
        $inscription->save();
        
        $id_new_inscription = $inscription->id;

        $userInscription = new UserInscription;
        $userInscription->id_inscription = $id_new_inscription ;
        $userInscription->id_user = 552;
        $userInscription->service_order = null;
        $userInscription->voucher = null;
        $userInscription->voucher_hash = null;
        $userInscription->payment_form = 0;
        $userInscription->payment_condition = 0;
        $userInscription->point = 0;
        $userInscription->condicion = 0;
        $userInscription->assistence = 0;
        $userInscription->ruc_subcontrata = null;
        $userInscription->subcontrata = null;
        $userInscription->obs = null;
        $userInscription->state = 0;
        $userInscription->id_user_inscription = 0;
        $userInscription->code_transaction = 0;
        $userInscription->save();

        return redirect()->route('register_cm',$id_new_inscription)->with('success','La inscripcion fue registrada');
    }
    public function register_cm($id)
    {
        $inscription =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')    
                        ->join('courses','inscriptions.id_course','=','courses.id')                    
                        ->select('inscriptions.id as id','courses.name as nameCourse','locations.name as nameLocation','startDate','endDate','address','time','slot','inscriptions.state as state','hh')
                        ->where('inscriptions.id',$id)
                        ->get();

        $facilitador = DB::table('user_inscriptions')
                        ->join('users','users.id','=','user_inscriptions.id_user')
                        ->where('user_inscriptions.id_inscription',$id)
                        ->select(DB::raw('CONCAT(name, " ", firstlastname, " ",secondlastname) AS full_name'))
                        ->get();
        
        return view('CentroMedico.register',compact('inscription','facilitador'));
    }

    // HENRY JOEL SAIRITUPAC ARONES
    public function delete_inscription_participante(request $request)
    {
        // id de inscripcion actual
        $id_inscription = $request->id_inscription;

        // list de ids a anular
        $ids = $request->get('ids');

        $cantidad = DB::table('user_inscriptions')
                    ->where('id_inscription',$id_inscription)
                    ->where('state',0)
                    ->count();

        // cambimos el estado a 2(anulado) del particonte
        DB::table('user_inscriptions')
            ->whereIn('id',$ids)->update(['state' => 2]);

        // incrementmaos el numero de vacantes
        DB::table('inscriptions')
            ->where('id',$id_inscription)
            ->increment('slot', count($ids));

        if ($cantidad > 0) {
            $id_inscription = $request->id_inscription;
            
            return redirect()->route('detail-inscriptionc', $id_inscription);
        }

        return redirect()->route('inscription_participants_details');

    }

    public function reschedule_validate(request $request) {
        // recuperamos el usuario logeado
        $idUser = Auth::id();

        // Recuperamos id de la incripcion actual
        $id_inscription = $request->id_inscription;
        // ids de partcipantes a repogramar
        $ids = $request->participants;

        // id de la nueva inscripcion a reprogramar
        $id_course = $request->id_new_inscription;

        // aumentamos el numero de vacantes a la aula actual
        DB::table('inscriptions')
           ->where('id',$id_inscription)
           ->increment('slot', count($ids));

        // actualizacion de los prticipantes a su nueva aula
        foreach ($ids as $id) {
           DB::table('user_inscriptions')->where('id', $id)
                ->update([
                    'id_inscription' => $id_course,
                    'state' => 1,
                ]);
        }
        // disminuir el numero de vacantes en la nueva aula 
        DB::table('inscriptions')
           ->where('id',$id_course)
           ->decrement('slot', count($ids));

        return redirect()->route('inscription_participants_details');
    }

    public function reschedule_user(request $request) {

        $ids = $request->get('ids');
        $id = $request->id_inscription;
        $user = Auth::user();
        $inscriptions =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location', '=', 'locations.id')
                        ->select('inscriptions.id as id','nameCurso',
                            'locations.name as nameLocation','startDate', 'id_course',
                            'address','time','inscriptions.state as state')
                        ->where('inscriptions.id', $id)
                        ->get();
        // inscripcion al que esta inscrito
        $id_insc = $inscriptions[0]->id;

        $participants = DB::table('users')
                        ->join('user_inscriptions','users.id', '=', 'user_inscriptions.id_user')
                        ->select('users.id as id','dni','firstlastname','secondlastname','name','user_inscriptions.state', 'user_inscriptions.id as idUI')
                        ->whereIn('user_inscriptions.id',$ids)
                        ->get();

        $courses =  DB::table('inscriptions')
                        ->join('locations','inscriptions.id_location','=','locations.id')
                        ->join('courses', 'courses.id', '=', 'inscriptions.id_course')
                        ->select('inscriptions.id as id', 'nameCurso',
                            'locations.name as nameLocation','startDate',
                            'time','slot',
                            'inscriptions.state as state','hours')
                        ->where('type',0)
                        ->where('slot','>',0)
                        ->where('courses.id_unity', $user->id_unity)
                        ->where('startDate', '>=', date('Y-m-d'))
                        ->where('inscriptions.id', '<>', $id_insc)
                        ->orderBy('startDate', 'des')
                        ->get();

        return view('inscriptions.reschedule_user', compact('inscriptions', 'participants', 'courses'));
    }
    public function register_part_manual()
    {
         $solicitantes = DB::table('users')
                        ->join('role_user','users.id','=','role_user.user_id')   
                        ->select('users.id','users.name','firstlastname','secondlastname')  
                        ->where('users.state',0)                   
                        ->where('role_id',4)
                        ->get(); 

        $participantes = DB::table('users')
                        ->join('role_user','users.id','=','role_user.user_id') 
                         ->select('users.id','users.name','firstlastname','secondlastname')  
                        ->where('users.state',0)                          
                        ->where('role_id',5)
                        ->get(); 
        return view('inscriptions.register_participant_manual',compact('solicitantes','participantes'));
    }
    public function register_part_manual_post(Request $request)
    {        
        $userInscription = new UserInscription;
        $userInscription->id_inscription = $request->id;
        $userInscription->id_user = $request->solicitante;
        $userInscription->service_order = null;
        if ($request->voucher != "") {
            $name_original = $request->file('voucher')->getClientOriginalName();
            $name = $request->file('voucher');
            $name_hash = $name->hashName();
            Storage::disk('public')->put('upload', $name);
            $userInscription->voucher = $name_original;
            $userInscription->voucher_hash = $name_hash;
        }else{
            $userInscription->voucher = "";
            $userInscription->voucher_hash = "";
        }
        $userInscription->payment_form = 0;
        $userInscription->payment_condition = 0;
        $userInscription->point = 0;
        $userInscription->condicion = 0;
        $userInscription->assistence = 0;
        $userInscription->ruc_subcontrata = null;
        $userInscription->subcontrata = null;
        $userInscription->obs = null;
        $userInscription->state = 0;
        $userInscription->id_user_inscription = 0;
        $userInscription->code_transaction = 0;
        $userInscription->save();

        $id_new_inscription = $userInscription->id;

        $userInscription2 = new UserInscription;
        $userInscription2->id_inscription = $request->id;
        $userInscription2->id_user = $request->participante;
        $userInscription2->service_order = null;
        if ($request->voucher != "") {
            $name_original = $request->file('voucher')->getClientOriginalName();
            $name = $request->file('voucher');
            $name_hash = $name->hashName();
            Storage::disk('public')->put('upload', $name);
            $userInscription2->voucher = $name_original;
            $userInscription2->voucher_hash = $name_hash;
        }else{
            $userInscription2->voucher = "";
            $userInscription2->voucher_hash = "";
        }
        $userInscription2->payment_form = 0;
        $userInscription2->payment_condition = 0;
        $userInscription2->point = 0;
        $userInscription2->condicion = 0;
        $userInscription2->assistence = 0;
        $userInscription2->ruc_subcontrata = null;
        $userInscription2->subcontrata = null;
        $userInscription2->obs = null;
        $userInscription2->state = 0;
        $userInscription2->id_user_inscription = $id_new_inscription;
        $userInscription2->code_transaction = 0;
        $userInscription2->save();
    }


    // funcion q exporta los partipntes de uan inscripcion
    public function export_inscription(Request $request) {

        $id = $request->id;

        $id_course = Inscription::findOrFail($id)->id_course;
        //dd($id_course);

        if ($id_course == 8 ) {
            $participants = DB::table('user_inscriptions')
                ->select(
                    'U.dni as DNI',
                    'U.firstlastname as AP_PATERNO','U.secondlastname as AP_MATERNO', 'U.name as NOMBRES',
                    'U.position as CARGO', 'U.superintendence as  AREA',
                    DB::raw('IF(companies.ruc="20508931621", "20100136741",companies.ruc) as RUC'),
                    DB::raw('IF(businessName="IGH GROUP","Minsur S. A.",businessName) as EMPRESA'),
                    DB::raw('IF(recuperations.point, recuperations.point ,user_inscriptions.point) as NOTA'),
                    DB::raw('IF(recuperations.point, user_inscriptions.point, NULL) as SUSTITUTORIO')
                )
                ->join('users as U','U.id','=','user_inscriptions.id_user')
                ->join('users as UC','UC.id','=','user_inscriptions.id_user_inscription')
                ->join('companies','companies.id','=','UC.id_company')
                ->leftJoin('recuperations', 'recuperations.id_user_inscription', '=', 'user_inscriptions.id')
                ->where('user_inscriptions.state','<>',2)
                ->where('user_inscriptions.id_inscription',$id)
                ->orderBy('user_inscriptions.id')
                ->get();


        } else {
            $participants = DB::table('user_inscriptions')
                ->select(
                    'U.dni as DNI',
                    'U.firstlastname as AP_PATERNO','U.secondlastname as AP_MATERNO', 'U.name as NOMBRES',
                    'U.position as CARGO', 'U.superintendence as  AREA',
                    DB::raw('IF(companies.ruc="20508931621", "20100136741",companies.ruc) as RUC'),
                    DB::raw('IF(businessName="IGH GROUP","Minsur S. A.",businessName) as EMPRESA'),
                    'point as NOTA')
                ->join('users as U','U.id','=','user_inscriptions.id_user')
                ->join('users as UC','UC.id','=','user_inscriptions.id_user_inscription')
                ->join('companies','companies.id','=','UC.id_company')
                ->where('user_inscriptions.state','<>',2)
                ->where('user_inscriptions.id_inscription',$id)
                ->get();
        }

        if ($participants->count() == 0) {
            Excel::Create('Inscripcion '.$id, function ($excel) use($id_course) {
                $excel->sheet('Lista De Participantes', function($sheet) use($id_course) {
                    $header = array('DNI', 'AP_PATERNO', 'AP_MATERNO', 'NOMBRES', 'CARGO', 'AREA', 'RUC', 'EMPRESA', 'NOTA');
                    if ($id_course == 8) {
                        $header = array('DNI', 'AP_PATERNO', 'AP_MATERNO', 'NOMBRES', 'CARGO', 'AREA', 'RUC', 'EMPRESA', 'NOTA', 'SUSTITUTORIO');
                    }

                    $sheet->setColumnFormat(array(
                        'A' => '@',
                        'G' => '@',
                        'I' => '0',
                        'J' => '0'
                    ));

                    $sheet->setWidth('A', 12);
                    $sheet->setWidth('B', 18);
                    $sheet->setWidth('C', 18);
                    $sheet->setWidth('D', 22);
                    $sheet->setWidth('E', 25);
                    $sheet->setWidth('F', 25);
                    $sheet->setWidth('G', 17);
                    $sheet->setWidth('H', 28);
                    $sheet->setWidth('I', 8);
                    $sheet->setWidth('J', 13);
                    $sheet->row(1, $header);
                    $sheet->row(1, function($row) {
                        // call cell manipulation methods
                        $row->setBackground('#2980b9');
                        $row->setFontColor('#ffffff');
                        $row->setFont(array(
                            'bold' => true
                        ));
                    });
                });
            })->export('xlsx');
        } else {
            Excel::Create('Inscripcion '.$id, function ($excel) use($participants) {
                // Set the title
                $excel->setTitle('lista de particpantes minsur');
                // Chain the setters
                $excel->setCreator('IGH Group')
                    ->setCompany('IGH');
                // Call them separately
                $excel->setDescription('lista de participantes del curso de la unidad minera');
                $excel->sheet('lista participante', function ($sheet) use($participants) {
                    $data = json_decode( json_encode($participants), true);
                    $sheet->setColumnFormat(array(
                        'A' => '@',
                        'G' => '@',
                        'I' => '0'
                    ));
                    $sheet->fromArray($data, null, 'A1', false, true);

                    $sheet->row(1, function($row) {

                        // call cell manipulation methods
                        $row->setBackground('#2980b9');
                        $row->setFontColor('#ffffff');
                        $row->setFont(array(
                            'bold' => true
                        ));
                    });
                });
            })->export('xlsx');

        }

    }

    // funcion para subir notas
    public function import_inscription(Request $request) {
        // id de usuario facilitdor que ah logeado

        $user = Auth::user();
        $id_user = $user->id;

        // id de la isncripcion si es en unidad o extraordinario
        $id_inscription = $request->id;
        $inscription = Inscription::find($id_inscription);
        $id_localidad = $inscription->id_location;

        $id_course = $inscription->id_course;

        $pago = 'a cuenta';
        if ($id_localidad == 2) {
         $pago = 'al contado';
        }

        // id de la unidad minera del facilitador
        $id_unity = $user->id_unity;

        //funcion para leer el excel ingreasado
        Excel::load($request->file_up, function ($reader) use($id_inscription, $pago, $id_unity, $id_user, $user, $id_course) {

            $results = $reader->get();
            $results->each(function ($row) use($id_inscription, $id_unity, $id_user, $pago, $user, $id_course ){
                // buscamos al partcipante por su dni y con rol 5 que pertenecas a la unidad
                $participant = DB::table('users')
                    ->select('users.id as id', 'users.dni', 'users.firstlastname', 'users.secondlastname', 'users.name',
                        'users.id_unity', 'users.id_company', 'role_id')
                    ->join('role_user','role_user.user_id','=','users.id')
                    ->where('dni', trim($row->dni))
                    ->where('id_unity', $id_unity)
                    ->where('role_id', 5);
                // verificamos si el usuario existe
                $exist_participante = $participant->exists();
                /*  buscmos el Usuario Responsable de la contrata para obtenr su "id" de compania */
                // si el cliente es MINSUR el responsable es el usurio facilitdor y lo validaso por su ruc
                if ($row->ruc == '20100136741') {
                    $user_contrata = $user;
                } else {
                    $user_contrata = DB::table('users')
                        ->select('users.id as id', 'users.id_company', 'users.id_unity',
                            'companies.ruc', 'companies.businessName')
                        ->join('role_user','role_user.user_id','=','users.id')
                        ->join('companies', 'companies.id', '=', 'users.id_company')
                        ->where('id_unity', $id_unity)
                        ->where('ruc', $row->ruc)
                        ->where('role_id', 4);
                }
                //-- VALIDIAMOS SI EXISTE CONTRATA
                $exist_contrata = $user_contrata->exists();
                //-- VERFICAMOS SI EXISTE LA CONTRATA y no el partcipante
                if (!$exist_participante and $exist_contrata)
                {
                    //-- Usuario responsable de la compania
                    $uc = $user_contrata->get()[0];
                    // si el ruc es dos se le designa a minsur
                    if ($row->ruc == '20100136741') {
                        $id_company = 2;
                    } else {
                        $id_company = $uc->id_company;
                    }
                    $id_user_contrata = $uc->id;
                    // CREACION DEL NUEVO PARTCIPANTE
                    $participant = new User();
                    $participant->id_company = $id_company;
                    $participant->type_document = 0;
                    $participant->dni = trim($row->dni);
                    $participant->firstlastname = $row->ap_paterno;
                    $participant->secondlastname = $row->ap_materno;
                    $participant->name = $row->nombres;
                    $participant->position = $row->cargo;
                    $participant->phone = '987654321';
                    $participant->email = 'mail@mail.com';
                    $participant->password = bcrypt(md5($row->dni));
                    $participant->remember_token = null;
                    $participant->code_bloqueo = null;
                    $participant->medical_exam = null;
                    $participant->id_management = null;
                    $participant->superintendence = $row->area;
                    $participant->image = null;
                    $participant->image_hash = null;
                    $participant->birth_date = null;
                    $participant->gender = null;
                    $participant->origin = null;
                    $participant->address = null;
                    $participant->state = 0;
                    $participant->id_user = $id_user;
                    $participant->id_unity = $id_unity;
                    $participant->save();
                    $participant->roles()->sync(5);
                    /* CREACION DEL REGISTRO DEL EN LA INSCRIPCION DEL CURSO ASIGNADO */
                    $c = $user_contrata->first();
                    $id_particpante = $participant->id;
                    if ($row->ruc == '20100136741') {
                        $id_company = 2;
                        $c = $user;
                    }

                    //dd($c, $c->id, $c->id_company, $id_company);
                    if ($id_course == 8) {
                        //dd($row->nota, $row->sustitutorio);
                        if ($row->sustitutorio) {
                            $user_inscription = new UserInscription();
                            $user_inscription->id_inscription = $id_inscription;
                            $user_inscription->id_user = $id_particpante;
                            $user_inscription->payment_form = $pago;
                            $user_inscription->point = $row->sustitutorio;
                            $user_inscription->id_user_inscription = $c->id;
                            $user_inscription->id_company_inscription = $id_company;
                            $user_inscription->save();

                            $recuperation = new Recuperation();
                            $recuperation->id_user_inscription = $user_inscription->id;
                            $recuperation->id_inscription = $id_inscription;
                            $recuperation->point = $row->nota;
                            $recuperation->state = 0; //-- activo
                            $recuperation->created_user = $user->id;
                            $recuperation->	updated_user = $user->id;
                            $recuperation->save();

                        } else {
                            $user_inscription = new UserInscription();
                            $user_inscription->id_inscription = $id_inscription;
                            $user_inscription->id_user = $id_particpante;
                            $user_inscription->payment_form = $pago;
                            $user_inscription->point = $row->nota;
                            $user_inscription->id_user_inscription = $c->id;
                            $user_inscription->id_company_inscription = $id_company;
                            $user_inscription->save();
                        }
                    }else {
                        $user_inscription = new UserInscription();
                        $user_inscription->id_inscription = $id_inscription;
                        $user_inscription->id_user = $id_particpante;
                        $user_inscription->payment_form = $pago;
                        $user_inscription->point = $row->nota;
                        $user_inscription->id_user_inscription = $c->id;
                        $user_inscription->id_company_inscription = $id_company;
                        $user_inscription->save();
                    }
                } else {
                    if ($exist_contrata) {
                        // COMPLETAMOS LA CONSULTA del partipante
                        $p = $participant->first();
                        $c = $user_contrata->first();
                        $id_company =  $c->id_company;
                        //dd($c, $c->id, $c->id_company);

                        if ($row->ruc == '20100136741') {
                            $id_company = 2;
                            $c = $user;
                        }

                        if ($id_company == null)
                        {
                            dd($c);
                        }

                        if ($row->sustitutorio) {
                            $ui = UserInscription::updateOrCreate(
                                [
                                    'id_inscription' => $id_inscription,
                                    'id_user' => $p->id,
                                ],
                                [
                                    'payment_form' => $pago,
                                    'point' => $row->sustitutorio,
                                    'id_user_inscription' => $c->id,
                                    'id_company_inscription' => $id_company
                                ]
                            );
                            $recuperation = Recuperation::where([
                                ['id_user_inscription', $ui->id],
                                ['state', 0]
                            ]);

                            if ($recuperation->exists()) {
                                $re = $recuperation->first();
                                if ($re->point != $row->nota) {
                                    $recuperation->update([
                                        'point' => $row->nota,
                                        'user_update' => $user->id,
                                    ]);
                                }
                            } else {
                                $re = new Recuperation();
                                $re->id_user_inscription = $ui->id;
                                $re->id_inscription = $id_inscription;
                                $re->point = $row->nota;
                                $re->state = 0; //-- activo
                                $re->created_user = $user->id;
                                $re->updated_user = $user->id;
                                $re->save();
                            };
                        } else {
                            $ui = UserInscription::updateOrCreate(
                                [
                                    'id_inscription' => $id_inscription,
                                    'id_user' => $p->id,
                                ],
                                [
                                    'payment_form' => $pago,
                                    'point' => $row->nota,
                                    'id_user_inscription' => $c->id,
                                    'id_company_inscription' => $id_company
                                ]
                            );
                        }

                    }
                    else {
                        dd('no existe ruc de la empresa '.$row->ruc);
                    }
                }
            });
        });

        return redirect()->route('inscriptions.show', $request->id)->with('success','La inscripcion fue registrada');

    }
}
