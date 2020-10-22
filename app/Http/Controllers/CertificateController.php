<?php

namespace App\Http\Controllers;

use App\Course;
use App\Inscription;
use App\Recuperation;
use App\User;
use App\UserInscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Query;
use PDF;
use Excel;
use ZipArchive;
use QrCode;

class CertificateController extends Controller
{

    public function certification (Request $request) {
        $query = DB::table('user_inscriptions')
            ->select(
                'users.dni', 'users.firstlastname', 'users.secondlastname', 'users.name', 'users.id_unity',
                'user_inscriptions.id as id', 'user_inscriptions.point', 'user_inscriptions.state',
                'nameCurso as course', 'startDate as date',
                DB::raw('IF(user_inscriptions.point >= inscriptions.point_min , 1,0) as aprobado'),
                DB::raw('
                    IF(
                        user_inscriptions.point >= inscriptions.point_min ,
                        DATE_ADD(inscriptions.startDate, INTERVAL inscriptions.validaty year), 0
                    ) as vigencia'
                )
            )
            ->join('inscriptions','inscriptions.id', '=', 'user_inscriptions.id_inscription')
            ->join('users', 'users.id', '=', 'user_inscriptions.id_user')
            ->where('user_inscriptions.id',$request->id)
            ->whereIn('user_inscriptions.state', [0,1])
            ->first();
        $user = Auth::user();
        $dni = $query->dni;
        $nombres = $query->firstlastname.' '.$query->secondlastname.' '.$query->name;
        $curso = $query->course;
        setlocale(LC_TIME, 'Spanish');
        $date_start = Carbon::parse($query->date);
        $dia = $date_start->day;
        $mes = $date_start->localeMonth;
        $anio = $date_start->year;
        $fecha = $dia.' de '.ucfirst($mes).' del '.$anio;
        $xl = false;

        if (strlen($curso)>= 75) {
            $xl = true;
        }

        $id = str_pad($query->id,8,"0", STR_PAD_LEFT);
        $codigo = 'MI-'.$id;
        $view = 'certificado.minsur';

        if ($query->id_unity == 1) {
            $view = 'certificado.raura';
            $codigo = 'RA-'.$id;
        }

        if ($query->id_unity == 4) {
            $view = 'certificado.pisco';
        }

        $pdf = PDF::loadView($view, compact('dni', 'nombres', 'curso', 'fecha', 'codigo', 'xl'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('CERTIFICADO DE  '.$dni.'-'.$nombres.'- CURSO '.strtoupper($curso.'.pdf'));

    }

    public function anexo4 (Request $request) {
        $query = DB::table('user_inscriptions')
            ->select(
                'users.dni', 'users.firstlastname', 'users.secondlastname', 'users.name',
                'users.position', 'users.superintendence', 'users.id_unity',
                'user_inscriptions.id as id', 'user_inscriptions.point', 'user_inscriptions.state',
                'nameCurso as course', 'startDate as date',
                'inscriptions.id_course',
                'companies.businessName',
                DB::raw('IF(user_inscriptions.point >= inscriptions.point_min , 1,0) as aprobado'),
                DB::raw('
                    IF(
                        user_inscriptions.point >= inscriptions.point_min ,
                        DATE_ADD(inscriptions.startDate, INTERVAL inscriptions.validaty year), 0
                    ) as vigencia'
                )
            )
            ->join('inscriptions','inscriptions.id', '=', 'user_inscriptions.id_inscription')
            ->join('users', 'users.id', '=', 'user_inscriptions.id_user')
            ->join('companies', 'companies.id', '=', 'users.id_company')
            ->where('user_inscriptions.id', $request->id)
            ->whereIn('user_inscriptions.state', [0,1])
            ->first();
        $dni = $query->dni;
        $nombres = $query->firstlastname.' '.$query->secondlastname.' '.$query->name;
        $curso = $query->course;
        $company = $query->businessName;
        $area = $query->superintendence;
        $cargo = $query->position;
        setlocale(LC_TIME, 'Spanish');
        $date_start = Carbon::parse($query->date);
        $dia = $date_start->day;
        $mes = $date_start->localeMonth;
        $anio = $date_start->year;
        $fecha = $dia.' de '.ucfirst($mes).' del '.$anio;


        $id = str_pad($query->id,8,"0", STR_PAD_LEFT);
        $codigo = 'MI-'.$id;
        $view = 'certificado.anexo4_sanrafael';

        if ($query->id_unity == 1) {
            $codigo = 'RA-'.$id;
        }

        if ($query->id_course == 8 || $query->id_course == 125 ) {
            $view = 'certificado.anexo4_sanrafael';
        }

        if ($query->id_course == 71) {
            $view = 'certificado.anexo4_pucamarca';
        }

        $text = "ANEXO 4\nDNI: $dni\nParticipante: $nombres\nContratista: $company\nCargo:$cargo\nArea: $area\nFecha Induccion: $fecha";
        $codeQR = QrCode::format('png')->size(100)->generate($text);
    
        $pdf = PDF::loadView($view, compact('dni', 'nombres', 'curso', 'area', 'cargo', 'fecha', 'codigo', 'company', 'codeQR'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('CONSTANCIA DE  '.$dni.'-'.$nombres.'- CURSO '.strtoupper($curso.'.pdf'));
    }

    public function search (Request $request) {
        $cursos = [];
        $doc = $request->doc;

        if ($request->method() == 'POST') {

            $user = User::query()
                ->where('dni', $doc)
                ->where('id_unity', '4')
                ->first();

            $cursos = DB::table('user_inscriptions')
                ->select(
                    'user_inscriptions.id as id',
                    'user_inscriptions.point',
                    'inscriptions.point_min',
                    'inscriptions.id_course',
                    'users.firstlastname', 'users.secondlastname', 'users.name',
                    'nameCurso as curso', 'startDate as start',
                    DB::raw('IF(user_inscriptions.point >= inscriptions.point_min , 1,0) as aprobado'),
                    DB::raw('
                            IF(user_inscriptions.point >= inscriptions.point_min ,
                             DATE_ADD(inscriptions.startDate, INTERVAL inscriptions.validaty year), 0
                             ) as end'
                    )
                )
                ->join('inscriptions','inscriptions.id', '=', 'user_inscriptions.id_inscription')
                ->join('users', 'users.id', '=', 'user_inscriptions.id_user')
                ->join('role_user','role_user.user_id', '=', 'users.id')
                ->where('role_id', 5)
                ->where('users.dni',$doc)
                ->whereRaw('user_inscriptions.point>=inscriptions.point_min')
                ->whereIn('user_inscriptions.state', [0,1])
                ->get();
        };
        return view('certificado.search', compact('cursos', 'user'));
    }


    public function cargardni(Request $request) {

        //dd('ente');
        $iguales = [];
        $notExist1 = [];
        $notExist2 = [];
        $masExist1 = [];
        $masExist2 = [];
        $notcourse = [];
        //funcion para leer el excel ingreasado

        Excel::load($request->file_up, function ($reader) use(&$iguales, &$notExist1, &$notExist2, &$notcourse, &$masExist1, &$masExist2) {

            $results = $reader->get();
            $results->each(function ($row) use(&$iguales, &$notExist1, &$notExist2 , &$notcourse, &$masExist1, &$masExist2){
                if ($row->dni1 === $row->dni2) {
                    array_push($iguales, $row->dni1);
                } else {
                    $users1 = DB::table('users')
                        ->select('users.id as id', 'users.dni', 'users.firstlastname', 'users.secondlastname', 'users.name',
                            'users.id_unity', 'users.id_company', 'role_id')
                        ->join('role_user','role_user.user_id','=','users.id')
                        ->where('dni', trim($row->dni1))
                        ->where('id_unity', 2)
                        ->where('role_id', 5);

                    $users2 = DB::table('users')
                        ->select('users.id as id', 'users.dni', 'users.firstlastname', 'users.secondlastname', 'users.name',
                            'users.id_unity', 'users.id_company', 'role_id')
                        ->join('role_user','role_user.user_id','=','users.id')
                        ->where('dni', trim($row->dni2))
                        ->where('id_unity', 2)
                        ->where('role_id', 5);

                    if ($users1->count() == 1 and $users2->count() == 1) {
                        $id1 = $users1->first()->id;
                        $course = DB::table('user_inscriptions')
                            ->where('id_user', $id1);

                        if ($course->count() == 0) {
                            array_push($notcourse, $row->dni1);
                        } else {
                            // actualizamos los curso al usuario correcto
                            $id2 = $users2->first()->id;
                            $course2 = DB::table('user_inscriptions')
                                ->where('id_user', $id2);
                            $u = DB::table('users')->where('id', $id1);

                            $course->update(['id_user' => $id2]);
                            $u->update(['state' => 1]);
                            //dd($id1, $id2, $course->count(), $course2->count(), $u->get());
                        }

                    } else {
                        if ($users1->count() == 0) {
                            array_push($notExist1, $row->dni1);
                        }
                        if ($users2->count() == 0) {
                            array_push($notExist2, $row->dni2);
                        }

                        if ($users1->count() > 1) {
                            array_push($masExist1, $row->dni1);
                        }
                        if ($users2->count() > 1) {
                            array_push($masExist2, $row->dni2);
                        }
                    }
                }
            });
            dd(
                'error los dni(s) 1 no existe '.json_encode($notExist1),
                'error los dni(s) 2 no existe '.json_encode($notExist2),
                'error los dni(s) 1 tienen mas de un usuario '.json_encode($masExist1),
                'error los dni(s) 2 tienen mas de un usuario '.json_encode($masExist2),
                'error los dni(s) 1 no tiene cursos '.json_encode($notcourse),
                'error los dni(s) son iguales '.json_encode($iguales)
            );
        });
        return redirect()->route('inscriptions.show', $request->id)->with('success','La inscripcion fue registrada');
    }

    public function ingresar(Request $request) {
        return view('certificado.sustitutorio');
    }

    public function all_certification (Request $request) {
        ini_set('max_execution_time', 720000);
        ini_set('memory_limit', -1);
        setlocale(LC_TIME, 'Spanish');

        $user = User::findOrFail($request->id);
        $query = DB::table('user_inscriptions')
            ->select(
                'users.dni',
                DB::Raw('CONCAT(users.firstlastname, " ", users.secondlastname, " ", users.name) AS participante'),
                'user_inscriptions.id as id',
                'nameCurso as curso', 'startDate as fecha'

            )
            ->join('inscriptions','inscriptions.id', '=', 'user_inscriptions.id_inscription')
            ->join('users', 'users.id', '=', 'user_inscriptions.id_user')
            ->where('users.id',$request->id)
            ->whereRaw('user_inscriptions.point>=inscriptions.point_min')
            ->whereIn('user_inscriptions.state', [0,1])
            ->get();

        $html = '';

        $view = 'certificado.minsur';

        if ($user->id_unity == 1) {
            $view = 'certificado.raura_all';
        }

        if ($user->id_unity == 4) {
            $view = 'certificado.pisco_all';
        }
        $pdf = PDF::loadView($view, compact('query'));
        $sheet = $pdf->setPaper('a4', 'landscape');

        return $sheet->download('CERTIFICADOS DE  '.strtoupper($user->name).' '.strtoupper($user->firstlastname).'.pdf');
    }

    public function course(Request $request) {
        $query = DB::table('courses')->whereIn('id', [98, 97,99,100,101,102,103,127,128,129,136,139,145, 156, 160])->get();

        return view('certificado.course', compact('query'));
        // return $query;
    }

    public function course_certificado_pisco(Request $request) {

        ini_set('max_execution_time', 720000);
        ini_set('memory_limit', -1);
        setlocale(LC_TIME, 'Spanish');
        $course = Course::findOrFail($request->id);
        $query = DB::table('user_inscriptions')
            ->select(
                'users.dni',
                DB::Raw('CONCAT(users.firstlastname, " ", users.secondlastname, " ", users.name) AS participante'),
                'user_inscriptions.id as id',
                'nameCurso as curso', 'startDate as fecha'

            )
            ->join('inscriptions','inscriptions.id', '=', 'user_inscriptions.id_inscription')
            ->join('users', 'users.id', '=', 'user_inscriptions.id_user')
            ->whereIn('user_inscriptions.state', [0,1])
            ->whereRaw('user_inscriptions.point>=inscriptions.point_min')
            ->where('users.id_company', 2)
            ->where('inscriptions.id_course', $request->id)
            ->orderBy('users.firstlastname')
            ->get();

        // vista del diseño del certificado
        $view = 'certificado.pisco_soli';
        // crear la carpeta del curso dodne se van a almacenar lso certificaodos
        $path = 'pisco/curso/'.$course->id.'-'.$course->name;

        $path_zip = storage_path('app/').'pisco/curso/';
        $zip_file = $course->id.'-'.str_slug($course->name).'.zip';
        $zip = new ZipArchive();
        // dd($path_zip.$zip_file);
        if ($zip->open($path_zip.$zip_file, ZipArchive::CREATE|ZipArchive::OVERWRITE) === TRUE) {

            // recorremos uno por uno cada partcipante
            foreach ($query as $item) {
                // nobre del arcivo 'CODIGO-DNI-NOMBRES'
                $nameFile = $item->id.' '.$item->dni.' '.$item->participante.'.pdf';
                $file = $path.'/'.$nameFile;
                //dd($path_zip);
                // DECLARACION DEL FLAT
                $flat = Storage::exists($file);

                // Si el archivo ya se encuentra en el servidor pasa a crear el archivo y almacenarlo en el mismo
                if (!$flat) {
                    $pdf = PDF::loadView($view, compact('item'));
                    $pdf->setPaper('a4', 'landscape');
                    $content = $pdf->download()->getOriginalContent();
                    // Almacenamos el archivo en su ruta respectiva
                    Storage::put($file, $content);
                    //dd($file);
                    if(file_exists(storage_path('app/').$file)) {
                        $zip->addFile(storage_path('app/').$file, $nameFile);
                    };
                } else {
                    // si el archvo ya se encuentra en el servidor
                    if(file_exists(storage_path('app/').$file)) {
                        $zip->addFile(storage_path('app/').$file, $nameFile);
                    };
                }

                /*$pdf->save(
                    public_path().'/mi_carpetita/'.$item->id.' '.$item->dni.' '.$item->participante.'.pdf'
                );*/
            }
        } else {
            dd('no entre');
        };
        // dd($path_zip.$zip_file);
        //return response()->download($zip_file);

        $zip->close();
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );

        $filetopath=$path_zip.$zip_file;

        return response()->download($filetopath, $zip_file, $headers);

//        dd('etc');
//
//        $pdf = PDF::loadView($view, compact('query'));
//        $sheet = $pdf->setPaper('a4', 'landscape');
//        return $sheet->download('certificado del '.$course->name.'.pdf');
    }

    public function export_certification(Request $request) {
        // Recuperamos el usuario usuario de la compañia
        $course = Course::findOrFail($request->id);
        $user = Auth::user();

        // recuperamos el el id de la unidad minera
        $id_unity = $user->id_unity;

        Excel::Create('Lista de participantes del curso '.$course->name, function ($excel)  use($request) {
            // Set the title
            $excel->setTitle('lista de particpantes minsur');
            // Chain the setters
            $excel->setCreator('IGH Group')
                ->setCompany('IGH');
            // Call them separately
            $excel->setDescription('lista de participantes');

            $excel->sheet('lista participante', function ($sheet) use($request) {

                $query = DB::table('user_inscriptions')
                    ->select(
                        'users.dni as documento',
                        DB::Raw('CONCAT(users.firstlastname, " ", users.secondlastname, " ", users.name) AS participante'),
                        'nameCurso as curso', 'startDate as fecha'
                    )
                    ->join('inscriptions','inscriptions.id', '=', 'user_inscriptions.id_inscription')
                    ->join('users', 'users.id', '=', 'user_inscriptions.id_user')
                    ->whereIn('user_inscriptions.state', [0,1])
                    ->whereRaw('user_inscriptions.point>=inscriptions.point_min')
                    ->where('users.id_company', 2)
                    ->where('inscriptions.id_course', $request->id)
                    ->get();

                $data = json_decode( json_encode($query), true);

                $sheet->fromArray($data, null, 'A1', false, true);
                $sheet->row(1, function($row) {
                    // call cell manipulation methods
                    $row->setBackground('#2980b9');
                    $row->setFontColor('#ffffff');
                });
            });

        })->export('xlsx');
    }

    public function covid (Request $request) {
        $query = DB::table('user_inscriptions')
            ->select(
                'users.dni', 'users.firstlastname', 'users.secondlastname', 'users.name',
                'users.position', 'users.superintendence', 'users.id_unity',
                'user_inscriptions.id as id', 'user_inscriptions.point', 'user_inscriptions.state',
                'nameCurso as course', 'startDate as date',
                'inscriptions.id_course',
                'companies.businessName',
                DB::raw('IF(user_inscriptions.point >= inscriptions.point_min , 1,0) as aprobado'),
                DB::raw('
                    IF(
                        user_inscriptions.point >= inscriptions.point_min ,
                        DATE_ADD(inscriptions.startDate, INTERVAL inscriptions.validaty year), 0
                    ) as vigencia'
                )
            )
            ->join('inscriptions','inscriptions.id', '=', 'user_inscriptions.id_inscription')
            ->join('users', 'users.id', '=', 'user_inscriptions.id_user')
            ->join('companies', 'companies.id', '=', 'users.id_company')
            ->where('user_inscriptions.id', $request->id)
            ->whereIn('user_inscriptions.state', [0,1])
            ->first();
        $dni = $query->dni;
        $nombres = $query->firstlastname.' '.$query->secondlastname.' '.$query->name;
        $curso = $query->course;
        $company = $query->businessName;
        $area = $query->superintendence;
        $cargo = $query->position;
        setlocale(LC_TIME, 'Spanish');
        $date_start = Carbon::parse($query->date);
        $dia = $date_start->day;
        $mes = $date_start->localeMonth;
        $anio = $date_start->year;
        $fecha = $dia.' de '.ucfirst($mes).' del '.$anio;


        $id = str_pad($query->id,8,"0", STR_PAD_LEFT);
        $codigo = 'MI-'.$id;
        $view = 'certificado.covid19_sanrafael';

        if ($query->id_unity == 1) {
            $codigo = 'RA-'.$id;
        }

        if ($query->id_course == 3 || $query->id_course == 160) {
            $view = 'certificado.covid19_pisco';
        }

        $text = "Constancia \nDNI: $dni\nParticipante: $nombres\nContratista: $company\nCargo:$cargo\nArea: $area\nFecha: $fecha";
        $codeQR = QrCode::format('png')->size(100)->generate($text);

        $pdf = PDF::loadView($view, compact('dni', 'nombres', 'curso', 'area', 'cargo', 'fecha', 'codigo', 'company', 'codeQR'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('CONSTANCIA DE  '.$dni.'-'.$nombres.'- CURSO '.strtoupper($curso.'.pdf'));
    }
}
