<?php

namespace App\Http\Controllers;

use App\Company;
use App\Invoice;
use App\Unity;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Excel;
use PhpParser\Node\Stmt\DeclareDeclare;

class InvoiceController extends Controller
{
    public function invoice(Request $request) {
        $id_user_inscription = $request->idUserInscription;
        $start = $request->start;
        $end = $request->end;
        $month = Carbon::parse($request->end)->month;
        $user = DB::table('users')->find($id_user_inscription);
        $id_company = $request->company;
        $id_unity = $request->unity;
        $cobros = $request->cobros;
        $precio = 13;
        $horas = $request->horas;
        $igv = 18;

        $state = 1; // estado 0 anulada, estado 1 activo

        $invoice = new Invoice;
        $invoice->id_user_inscription = $id_user_inscription;
        $invoice->id_company = $id_company;
        $invoice->id_unity = $id_unity;
        $invoice->start_date = $start;
        $invoice->end_date = $end;
        $invoice->cobros = $cobros;
        $invoice->precio = $precio;
        $invoice->horas = $horas;
        $invoice->igv = $igv;
        $invoice->state = $state;
        $invoice->save();

        $msg = 'La factura fue registrada correctamente';
        dd($msg);
//        return redirect()->route('report_company_participant',
//            [$id_user_inscription.'/'.$start.'/'.$end])
//            ->with('success',$msg);



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
                'codigo_company', 'ruc', 'businessName',
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



        return view('companies.report_list_company',
            compact('query', 'count_company',
                'total_horas', 'total_cobros', 'monto_total', 'id_unity', 'start', 'end'));
    }

    public function report_valorization ($id) {

        // buscamos la valorizacion
        $invoice = Invoice::findOrFail($id);
        // seleccioans la unidad que esta la valurizacion
        $id_unity = $invoice->id_unity;

        // mostramos el formato del el exel de acurod a la unidad
        if ($id_unity != 1) {
            $source = public_path('files/formato-val-minsur.xlsx');
        } else {
            $source = public_path('files/formato-val-raura.xlsx');
        }

        // --
        //  proceso para la primera hoja
        // --

        // recuperamos los id
        $id_company = $invoice->id_company;
        $id_unity = $invoice->id_unity;

        // buscamaos la company y unity
        $company = Company::find($id_company);
        $unity = Unity::find($id_unity);

        // nombre de la unidad y compania
        $name_unity = $unity->name;
        $name_company = $company->businessName;

        $horas = $invoice->horas;
        $cobros = $invoice->cobros;
        $precio = $invoice->precio;
        $total = $cobros * $precio;

        setlocale(LC_TIME, 'Spanish');
        /** Fechas de corte **/

        // primera fecha
        $date_start = Carbon::parse($invoice->start_date);
        $dia1 = $date_start->day;
        $mes1 = $date_start->localeMonth;
        $anio1 = $date_start->year;

        // segunda fecha
        $date_end = Carbon::parse($invoice->end_date);
        $dia2 = $date_end->day;
        $mes2 = $date_end->localeMonth;
        $anio2 = $date_end->year;

        $periodo = $dia1.' '.$mes1.' '.$anio1.' al '.$dia2.' '.$mes2.' '.$anio2;
        //dd($this->convertir(99.99, 'soles'));
        $total_igv = $total + $total*0.18;
        $total_texto = 'TOTAL A PAGAR: S/ '.$total_igv.' (INC. IGV) '.$this->convertir($total_igv, 'soles');

        // --
        // Proceso para la SEGUNDA HOJA
        // --

        // recuperamos el id de la cuenta de usaurio responable de la contrata(company) de inscripcion
        $user_inscription = DB::table('users')
            ->select('users.id')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('role_user.role_id', 4)
            ->where('users.id_company', $id_company)
            ->where('users.id_unity', $id_unity)
            ->first();

        // dd($user_inscription);

        // recuperamos las fechas de corte
        $start = $invoice->start_date;
        $end = $invoice->end_date;

        $participant = DB::table('user_inscriptions')
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
            ->where('user_inscriptions.id_user_inscription', $user_inscription->id)
            ->orderBy('dni')
            ->get();

        $data = json_decode( json_encode($participant), true);

        Excel::load($source, function ($file) use($company, $horas, $name_unity, $periodo, $cobros, $total, $precio, $total_texto, $data) {
            // RECUPERAMOS EL FORMATO BASE DE LA VALORIZACION
            $sheet = $file->getExcel()->getActiveSheet(0);

            // primer sheet(hoja)
            $sheet->setCellValue('C7', $company->businessName);
            $sheet->setCellValue('G7', $company->ruc);
            $sheet->setCellValue('C9', strtoupper($name_unity));
            $sheet->setCellValue('H10', $total);
            $sheet->setCellValue('C10', $periodo);
            $sheet->setCellValue('E18', $horas);
            $sheet->setCellValue('F18', $cobros);
            $sheet->setCellValue('G18', $precio);
            $sheet->setCellValue('B24', $total_texto);
            // Segunda hoja

            $file->sheet('Participantes', function ($sheet) use ($data) {
                //dd($data);

                $sheet->fromArray($data, null, 'A2', false, false);
            });

        }, 'UTF-8')->download('xlsx');
    }

    private static $UNIDADES = [
        '',
        'UN ',
        'DOS ',
        'TRES ',
        'CUATRO ',
        'CINCO ',
        'SEIS ',
        'SIETE ',
        'OCHO ',
        'NUEVE ',
        'DIEZ ',
        'ONCE ',
        'DOCE ',
        'TRECE ',
        'CATORCE ',
        'QUINCE ',
        'DIECISEIS ',
        'DIECISIETE ',
        'DIECIOCHO ',
        'DIECINUEVE ',
        'VEINTE '
    ];

    private static $DECENAS = [
        'VEINTI',
        'TREINTA ',
        'CUARENTA ',
        'CINCUENTA ',
        'SESENTA ',
        'SETENTA ',
        'OCHENTA ',
        'NOVENTA ',
        'CIEN '
    ];
    private static $CENTENAS = [
        'CIENTO ',
        'DOSCIENTOS ',
        'TRESCIENTOS ',
        'CUATROCIENTOS ',
        'QUINIENTOS ',
        'SEISCIENTOS ',
        'SETECIENTOS ',
        'OCHOCIENTOS ',
        'NOVECIENTOS '
    ];
    public function convertir(float $number, string $currency)
    {
        $base_number = round($number, 2);
        $converted = '';
        $decimales = '';
        if (($base_number < 0) || ($base_number > 999999999)) {
            return 'No es posible convertir el número en letras';
        }
        $div_decimales = explode('.', $base_number);
        if (count($div_decimales) > 1) {
            $base_number = $div_decimales[0];
            $decNumberStr = (string)$div_decimales[1];
            if (strlen($decNumberStr) == 1) {
                $decNumberStr .= '0';
            }
            if (strlen($decNumberStr) == 2) {
                $decNumberStrFill = str_pad($decNumberStr, 9, '0', STR_PAD_LEFT);
                $decCientos = substr($decNumberStrFill, 6);
                $decimales = self::convertirGrupo($decCientos);
            }
        }
        $numberStr = (string)$base_number;
        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);
        if ($div_decimales[0] == 0) {
            $converted .= 'CERO';
        }
        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'UN MILLON ';
            } else if (intval($millones) > 0) {
                $converted .= sprintf('%sMILLONES ', self::convertirGrupo($millones));
            }
        }
        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'MIL ';
            } else if (intval($miles) > 0) {
                $converted .= sprintf('%sMIL ', self::convertirGrupo($miles));
            }
        }
        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $converted .= '';
            } else if (intval($cientos) > 0) {
                $converted .= sprintf('%s ', self::convertirGrupo($cientos));
            }
        }

        if (empty($decimales)) {
            $valor_convertido = trim($converted) . ' CON ' . '00/100 ' . mb_strtoupper($currency);
        } else {
            $valor_convertido = trim($converted) . ' CON ' . $decNumberStr . '/100 ' . mb_strtoupper($currency);
        }
        return trim($valor_convertido);
    }
    private static function convertirGrupo($n)
    {
        $output = '';
        if ($n == '100') {
            $output = "CIEN ";
        } else if ($n[0] !== '0') {
            $output = self::$CENTENAS[$n[0] - 1];
        }
        $k = intval(substr($n, 1));
        if ($k <= 20) {
            $output .= self::$UNIDADES[$k];
        } else {
            if (($k > 30) && ($n[2] !== '0')) {
                $output .= sprintf('%sY %s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            }
        }
        return $output;
    }

}
