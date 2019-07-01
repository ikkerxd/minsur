<?php

namespace App\Http\Controllers;

use App\Company;
use App\Invoice;
use App\Unity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Excel;
use PhpParser\Node\Stmt\DeclareDeclare;

class InvoiceController extends Controller
{
    public function invoice(Request $request) {
        $numInvoice = $request->nroFactura;
        $id_user_inscription = $request->idUserInscription;
        $start = $request->start;
        $end = $request->end;
        $month = Carbon::parse($request->end)->month;
        $user = DB::table('users')->find($id_user_inscription);
        $id_company = $user->id_company;
        $id_unity = $user->id_unity;
        $cobros = $request->cobros;
        $precio = 13;
        $horas = $request->horas;
        $igv = 18;
        $state = 1; // estado 0 anulada, estado 1 facturado, estado 2 cobrado

        $invoice = new Invoice;
        $invoice->id_user_inscription = $id_user_inscription;
        $invoice->id_company = $id_company;
        $invoice->id_unity = $id_unity;
        $invoice->nro_invoice = $numInvoice;
        $invoice->start_date = $start;
        $invoice->end_date = $end;
        $invoice->cobros = $cobros;
        $invoice->precio = $precio;
        $invoice->horas = $horas;
        $invoice->igv = $igv;
        $invoice->state = 1;
        $invoice->save();

        $msg = 'La factura: '.$numInvoice.' fue registrada correctamente';
        return redirect()->route('report_company_participant',
            [$id_user_inscription.'/'.$start.'/'.$end])
            ->with('success',$msg);
    }

    public function report_valorization ($id) {

        $invoice = Invoice::find($id);
        $id_unity = $invoice->id_unity;

        if ($id_unity != 1) {
            $source = public_path('files/formato-val-minsur.xlsx');
        } else {
            $source = public_path('files/formato-val-raura.xlsx');
        }



        Excel::load($source, function ($file) use($id) {
            $invoice = Invoice::find($id);
            $id_company = $invoice->id_company;
            $id_unity = $invoice->id_unity;

            $company = Company::find($id_company);
            $unity = Unity::find($id_unity);
            $name_unity = $unity->name;

            $cobros = $invoice->cobros;
            $precio = $invoice->precio;
            $total = $cobros * $precio;
            // mes de facturacion
            setlocale(LC_TIME, 'Spanish');
            $date_start = Carbon::parse($invoice->start_date);
            $dia1 = $date_start->day;
            $mes1 = $date_start->localeMonth;
            $anio1 = $date_start->year;

            $date_end = Carbon::parse($invoice->end_date);
            $dia2 = $date_end->day;
            $mes2 = $date_end->localeMonth;
            $anio2 = $date_end->year;

            $periodo = $dia1.' '.$mes1.' '.$anio1.' al '.$dia2.' '.$mes2.' '.$anio2;
            //dd($this->convertir(99.99, 'soles'));
            $total_igv = $total + $total*0.18;
            $total_texto = 'TOTAL A PAGAR: S/ '.$total_igv.' (INC. IGV) '.$this->convertir($total_igv, 'soles');


            $sheet = $file->getExcel()->getActiveSheet(0);
            $sheet->setCellValue('C7', $company->businessName);
            $sheet->setCellValue('G7', $company->ruc);
            $sheet->setCellValue('C9', strtoupper($name_unity));
            $sheet->setCellValue('H10', $total);
            $sheet->setCellValue('C10', $periodo);
            $sheet->setCellValue('E18', $invoice->horas);
            $sheet->setCellValue('F18', $cobros);
            $sheet->setCellValue('G18', $precio);
            $sheet->setCellValue('B24', $total_texto);
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
