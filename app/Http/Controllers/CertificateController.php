<?php

namespace App\Http\Controllers;

use App\Inscription;
use App\Recuperation;
use App\User;
use App\UserInscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Query;
use PDF;
use Excel;

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

    public function search (Request $request) {
        $cursos = [];
        $doc = $request->doc;

        if ($request->method() == 'POST') {

            $cursos = DB::table('user_inscriptions')
                ->select(
                    'user_inscriptions.id as id',
                    'user_inscriptions.point',
                    'inscriptions.point_min',
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

        return view('certificado.search', compact('cursos'));
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
}
