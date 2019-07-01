<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Query;
use PDF;

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

        $dni = 72758139;
        $nombres = 'VILLENA SOTO KEYLER';
        //$nombres = 'TRILLO PEÑA WILFREDO ALBERTO';
        $fecha = '06 de Junio del 2019';
        $curso = 'RIESGOS CRITICOS 1';
        //$curso = 'SUSTANCIAS QUIMICAS PELIGROSAS';
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
        $codigo = 'PI-000000016';

        $pdf = PDF::loadView($view, compact('dni', 'nombres', 'curso', 'fecha', 'codigo', 'xl'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('certficado.pdf');
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
}
