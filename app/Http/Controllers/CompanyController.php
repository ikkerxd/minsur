<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Excel;
use Carbon\Carbon;
use MongoDB\Driver\Query;

// use Illuminate\Support\Facades\Mail;
// use App\Mail\SendMail;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:companies.create')->only(['create', 'store']);
        $this->middleware('permission:companies.index')->only('index');
        $this->middleware('permission:companies.edit')->only(['edit', 'update']);
        $this->middleware('permission:companies.show')->only('show');
        $this->middleware('permission:companies.destroy')->only('destroy');
    }
    
    public function index()
    {
        $user = Auth::user();
        $companies = DB::table('users')
            ->select('users.id as id_user', 'users.id_unity', 'users.id_company as id_company',
                    'users.phone','users.email', 'users.email_valorization',
                    'companies.businessName', 'companies.ruc', 'companies.address', 'companies.state')
            ->join('companies', 'companies.id', '=', 'users.id_company')
            ->join('role_user','role_user.user_id', '=', 'users.id')
            ->where('id_unity', $user->id_unity)
            ->where('role_id', 4)
            ->get();
        return view('companies.index',compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $company = new Company;
        $company->ruc = $request->ruc;
        $company->businessName = $request->businessName;
        $company->address = $request->address;
        $company->phone = $request->phone;
        $company->state = 0;
        $company->save();

        return redirect()->route('companies.index')->with('success','la empreas fue registrada');
    }

    public function show(Company $company)
    {
        $user = Auth::user();
        $users = DB::table('users')
            ->select('users.id as id', 'role_id',
                'users.dni', 'users.firstlastname', 'users.secondlastname', 'users.name',
                'users.position', 'users.superintendence', 'users.state')
            ->join('role_user','role_user.user_id', '=', 'users.id')
            ->where('id_unity', $user->id_unity)
            ->where('id_company', $company->id)
            ->where('role_id', 5)
            ->get();
        return view('companies.show',compact('company','users'));
        
    }

    public function edit(Company $company)
    {        
        return view('companies.edit',compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        $company->ruc = $request->ruc;
        $company->businessName = $request->businessName;
        $company->address = $request->address;
        $company->phone = $request->phone;        
        $company->save();

        return redirect()->route('companies.index')->with('success','la empresa fue actualizada');
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {            
            $company = \App\Company::find($id);
            $company->delete();  
            return response()->json(['success'   => $company->businessName.' fue eliminado.',]);          
        }
    }
    public function search_ruc(Request $request)
    {
        $ruc = $request->ruc;        
        $companies = DB::table('companies')->where('ruc', $ruc)->get();
        return response()->json($companies);
    }

    public function register_companyg()
    {
        return view('companies.create_company');        
    }
    public function register_companyp(Request $request)
    {        
        $company = new Company;
        $company->ruc = $request->ruc;
        $company->businessName = $request->businessName;
        $company->address = $request->address;
        $company->phone = "";
        $company->state = 0;
        $company->save();

        return redirect()->route('register');
    }

    public function report_company(Request $request) {
        // Recuperamos el usuario usuario de la compañia
        $id_um = $request->id;
        $user = Auth::user();
        $id_unity = $user->id_unity;


        // recuperamos el el id de la unidad minera
        $count_company = 0;
        $total_cobros = 0;
        $total_horas = 0;
        $monto_total = 0;
        $query = [];

        if ($request->method() == 'POST') {
                $start = $request->startDate;
            $end = $request->endDate;
            $sub_query = DB::table('user_inscriptions')
                ->select(
                    'companies.businessName as businessName', 'companies.ruc as ruc',
                    'users.email_valorization', 'users.phone',
                    'user_inscriptions.id_user_inscription',
                    DB::raw('SUM(inscriptions.hours) as total_horas'),
                    DB::raw('ROUND(COUNT(*)/2) as cobros')
                )
                ->join('users', 'users.id', '=', 'user_inscriptions.id_user_inscription')
                ->join('companies', 'companies.id', '=', 'users.id_company')
                ->join('inscriptions', 'inscriptions.id', '=', 'user_inscriptions.id_inscription')
                ->join('courses', 'courses.id', '=', 'inscriptions.id_course')
                ->whereIn('user_inscriptions.state', [0,1])
                ->where('users.id_unity', $id_unity)
                //->where('users.id_company', 107)
                ->where('courses.required','=', 0)
                ->where('user_inscriptions.payment_form', 'a cuenta')
                ->whereBetween('inscriptions.startDate', [$start, $end])
                ->groupBy('user_inscriptions.id_user_inscription', 'user_inscriptions.id_user');

            $query = DB::table( DB::raw("({$sub_query->toSql()}) as t") )
                ->mergeBindings($sub_query)
                ->select(
                    'ruc', 'businessName',
                    'email_valorization', 'phone',
                    'id_user_inscription',
                    DB::raw('SUM(total_horas) as horas'),
                    DB::raw('SUM(cobros) as total_cobros'),
                    DB::raw('SUM(cobros*13) as monto_cobros')
                )
                ->where('ruc', '<>', '20508931621')
                ->groupBy('ruc')
                ->get();

            $count_company = $query->count();
            $total_horas = $query->sum('horas');
            $total_cobros = $query->sum('total_cobros');
            $monto_total = $query->sum('monto_cobros');
            //dd($query1);

        }
        //return $sub_query->get();
            return view('companies.report_company_course',
                compact('query', 'count_company', 'total_horas', 'total_cobros', 'monto_total'));
    }


    public function report_list_company(Request $request) {
        $id_um = $request->id;
        $id_unity = $id_um;

        $start = null;
        $end = null;

        // recuperamos el el id de la unidad minera
        $count_company = 0;
        $total_cobros = 0;
        $total_horas = 0;
        $monto_total = 0;
        $query = [];

        if ($request->method() == 'POST') {

            $start = $request->startDate;
            $end = $request->endDate;
            $sub_query = DB::table('user_inscriptions')
                ->select(
                    'companies.id as codigo_company', 'companies.businessName as businessName', 'companies.ruc as ruc',
                    'users.email_valorization', 'users.phone',
                    'user_inscriptions.id_user_inscription',
                    DB::raw('SUM(inscriptions.hours) as total_horas'),
                    DB::raw('ROUND(COUNT(*)/2) as cobros')
                )
                ->join('users', 'users.id', '=', 'user_inscriptions.id_user_inscription')
                ->join('companies', 'companies.id', '=', 'users.id_company')
                ->join('inscriptions', 'inscriptions.id', '=', 'user_inscriptions.id_inscription')
                ->join('courses', 'courses.id', '=', 'inscriptions.id_course')
                ->whereIn('user_inscriptions.state', [0,1])
                ->where('users.id_unity', $id_unity)
                //->where('users.id_company', 107)
                ->where('courses.required','=', 0)
                ->where('user_inscriptions.payment_form', 'a cuenta')
                ->whereBetween('inscriptions.startDate', [$start, $end])
                ->groupBy('user_inscriptions.id_user_inscription', 'user_inscriptions.id_user');

            $query = DB::table( DB::raw("({$sub_query->toSql()}) as t") )
                ->mergeBindings($sub_query)
                ->select(
                    'invoices.id as codigo_invoices', 't.codigo_company', 't.ruc', 't.businessName',
                    't.email_valorization', 't.phone',
                    't.id_user_inscription as A',
                    DB::raw('SUM(t.total_horas) as horas'),
                    DB::raw('SUM(t.cobros) as total_cobros'),
                    DB::raw('SUM(t.cobros*13) as monto_cobros')
                )
                ->leftJoin('invoices', function ($join) use ($id_unity, $start, $end) {
                    $join->on('invoices.id_company', '=', 't.codigo_company')
                        ->where('invoices.id_unity', '=', $id_unity)
                        ->whereRaw('invoices.start_date=2019-07-25')
                        ->whereRaw('invoices.end_date=2019-08-24')
                    ;
                })
                ->where('t.ruc', '<>', '20508931621')
                ->groupBy('t.ruc')
                ->get();
            return $query;
            $count_company = $query->count();
            $total_horas = $query->sum('horas');
            $total_cobros = $query->sum('total_cobros');
            $monto_total = $query->sum('monto_cobros');
            //dd($query1);

        }
        //return $sub_query->get();
        return view('companies.report_list_company',
            compact('query', 'count_company',
                'total_horas', 'total_cobros', 'monto_total', 'id_unity', 'start', 'end'));
    }

    public function report_company_participant(Request $request) {
        // Recuperamos el usuario usuario de la compañia
        $user = Auth::user();

        // recuperamos el el id de la unidad minera
        $id_unity = $user->id_unity;
        $id_user_inscription = $request->id;
        $start = $request->startDate;
        $end = $request->endDate;


        // mes de facturacion
        setlocale(LC_TIME, 'Spanish');

        $dt0 = Carbon::parse($start);
        $dia0 = $dt0->day;
        $mes0 = $dt0->month;

        $dt = Carbon::parse($end);
        $dia1 =  $dt->day;
        $mes1 = $dt->month;

        $flat = ($dia0-$dia1==1 and $mes0-$mes1==-1) ? true : false;
        // mes solo para mostrar
        $mes = ucfirst($dt->localeMonth);


        // recueramos si tenemos una factura
        $invoice = DB::table('invoices')
                    ->where([
                        ['id_user_inscription', $id_user_inscription],
                        ['start_date', $start],
                        ['end_Date', $end],
                    ])->first();

        $query = DB::table('user_inscriptions')
            ->select(
                'UP.dni', 'UP.firstlastname', 'UP.secondlastname', 'UP.name', 'UP.superintendence',
                'companies.businessName', 'companies.ruc',
                'inscriptions.nameCurso', 'inscriptions.startDate'
            )
            ->join('users', 'users.id', '=', 'user_inscriptions.id_user_inscription')
            ->join('users as UP', 'UP.id', '=', 'user_inscriptions.id_user')
            ->join('companies', 'companies.id', '=', 'users.id_company')
            ->join('inscriptions', 'inscriptions.id', '=', 'user_inscriptions.id_inscription')
            ->join('courses', 'courses.id', '=', 'inscriptions.id_course')
            ->whereIn('user_inscriptions.state', [0,1])
            ->where('users.id_unity', $id_unity)
            ->where('courses.required','=', 0)
            ->whereBetween('inscriptions.startDate', [$start, $end])
            ->where('user_inscriptions.payment_form', 'a cuenta')
            ->where('user_inscriptions.id_user_inscription',$id_user_inscription)
            ->orderBy('dni')
            ->get();

        $sub_query = DB::table('user_inscriptions')
            ->select(
                'companies.businessName as businessName', 'companies.ruc as ruc',
                'users.email_valorization', 'users.phone',
                'user_inscriptions.id_user_inscription',
                DB::raw('SUM(inscriptions.hours) as total_horas'),
                DB::raw('ROUND(COUNT(*)/2) as cobros')
            )
            ->join('users', 'users.id', '=', 'user_inscriptions.id_user_inscription')
            ->join('companies', 'companies.id', '=', 'users.id_company')
            ->join('inscriptions', 'inscriptions.id', '=', 'user_inscriptions.id_inscription')
            ->join('courses', 'courses.id', '=', 'inscriptions.id_course')
            ->whereIn('user_inscriptions.state', [0,1])
            ->where('users.id_unity', $id_unity)
            ->where('courses.required','=', 0)
            ->where('user_inscriptions.payment_form', 'a cuenta')
            ->whereBetween('inscriptions.startDate', [$start, $end])
            ->where('user_inscriptions.id_user_inscription',$id_user_inscription)
            ->groupBy('user_inscriptions.id_user_inscription', 'user_inscriptions.id_user');

        $resultado = DB::table( DB::raw("({$sub_query->toSql()}) as t") )
            ->mergeBindings($sub_query)
            ->select(
                'ruc', 'businessName',
                'email_valorization', 'phone',
                'id_user_inscription',
                DB::raw('SUM(total_horas) as horas'),
                DB::raw('SUM(cobros) as total_cobros'),
                DB::raw('SUM(cobros*13) as monto_cobros')
            )
            ->where('ruc', '<>', '20508931621')
            ->groupBy('ruc')
            ->get()[0];

        $horas = $resultado->horas;
        $cobros = $resultado->total_cobros;
        $name_company = $query[0]->businessName;
        return view('companies.report_company_participant',
            compact('query', 'id_user_inscription', 'name_company', 'start', 'end', 'mes', 'horas', 'cobros', 'flat', 'invoice'));
    }

    public function report_debt()
    {
        $invoices = DB::table('companies')
        ->join('users','companies.id','=','users.id_company')  
        ->join('user_inscriptions','user_inscriptions.id_user','=','users.id')
        ->join('inscriptions','inscriptions.id','=','user_inscriptions.id_inscription')
        ->join('courses','courses.id','=','inscriptions.id_course')
        ->join('locations','locations.id','=','inscriptions.id_location')
        ->select(DB::raw('ruc,businessName,voucher,voucher_hash,count(*) as cantidad,payment_condition,courses.name as courseName,startDate,locations.name as nameLocation,user_inscriptions.id as id_user_inscription'))
        ->where('companies.id','<>',1)
        ->where('user_inscriptions.state','<>',2)
        ->groupBy('ruc','businessName','voucher','voucher_hash','payment_condition','courseName','startDate','nameLocation','user_inscriptions.id')
        ->orderBy('payment_condition','desc')
        ->get();
        return view('companies.invoice',compact('invoices'));
    }
    public function cons_part()
    {        
        $invoices = DB::table('companies')
        ->join('users','companies.id','=','users.id_company')
        ->join('user_inscriptions','user_inscriptions.id_user','=','users.id')
        ->join('role_user','users.id','=','user_id')
        ->join('inscriptions','inscriptions.id','=','user_inscriptions.id_inscription')
        ->join('courses','courses.id','=','inscriptions.id_course')
        ->join('locations','locations.id','=','inscriptions.id_location')
        ->where('role_user.role_id',5)
        ->where('companies.id','<>',1)
        ->where('user_inscriptions.state','<>',2)
        ->select(DB::raw('firstlastname,secondlastname,users.name as name,dni,businessName,inscriptions.startDate as fecIni,courses.name as courseName,courses.price as price,locations.name as sede,payment_condition'))           
        ->get();
        return view('companies.consolidado_participants',compact('invoices'));
    }

    public function export_participant(Request $request) {
        // Recuperamos el usuario usuario de la compañia
        $user = Auth::user();

        // recuperamos el el id de la unidad minera
        $id_unity = $user->id_unity;
        $id_company = $request->id;
        $start = $request->startDate;
        $end = $request->endDate;

        Excel::Create('participantes '.$id_company, function ($excel) use($id_company,$id_unity,$start,$end) {
            // Set the title
            $excel->setTitle('lista de particpantes minsur');
            // Chain the setters
            $excel->setCreator('IGH Group')
                ->setCompany('IGH');
            // Call them separately
            $excel->setDescription('lista de participantes para la facturacion');

            $excel->sheet('lista participante', function ($sheet) use($id_company,$id_unity,$start,$end) {

                $query = DB::table('user_inscriptions')
                    ->select(
                        'UP.dni as DNI',
                        'UP.firstlastname as Apellido Materno',
                        'UP.secondlastname as Apellido Paterno',
                        'UP.name as Nombre',
                        'UP.position as Cargo',
                        'UP.superintendence as Area',
                        'companies.businessName as Empresa',
                        'inscriptions.nameCurso as Curso',
                        'inscriptions.hours as Horas',
                        'inscriptions.startDate as Fecha'
                    )
                    ->join('users', 'users.id', '=', 'user_inscriptions.id_user_inscription')
                    ->join('users as UP', 'UP.id', '=', 'user_inscriptions.id_user')
                    ->join('companies', 'companies.id', '=', 'users.id_company')
                    ->join('inscriptions', 'inscriptions.id', '=', 'user_inscriptions.id_inscription')
                    ->join('courses', 'courses.id', '=', 'inscriptions.id_course')
                    ->whereIn('user_inscriptions.state', [0,1])
                    ->where('users.id_unity', $id_unity)
                    ->where('courses.required','=', 0)
                    ->where('user_inscriptions.payment_form', 'a cuenta')
                    ->whereBetween('inscriptions.startDate', [$start, $end])
                    ->where('user_inscriptions.id_user_inscription',$id_company)
                    ->orderBy('dni')
                    ->get();
                $data = json_decode( json_encode($query), true);

//                $sheet->setColumnFormat(array(
//                    'G' => '0'
//                ));
                $sheet->fromArray($data, null, 'A1', false, true);
                $sheet->row(1, function($row) {
                    // call cell manipulation methods
                    $row->setBackground('#2980b9');
                    $row->setFontColor('#ffffff');
                });
            });
        })->export('xlsx');
    }

    /*public function enviar_correo()
    {
        $data = array('title' => 'Adjunto comprobante de pago');
        Mail::send('dynamic_email_template',$data, function($message){
            $pathToFile = 'https://cdne.ojo.pe/thumbs/uploads/img/2018/05/16/imagen-de-mario-sin-bigote-deja-en-shock-a-muchos--256300-jpg_700x0.jpg';  
            $mime = 'image/jpg';
            $display = 'voucher';
            $message->to('lvegameza@gmail.com')
                    ->subject('Laravel File attachment')
                    ->attach($pathToFile, ['as' => $display, 'mime' => $mime]);;
            $message->from('sistemas@ighgroup.com','Sistema Online - MMG');
        });
    }*/
}
