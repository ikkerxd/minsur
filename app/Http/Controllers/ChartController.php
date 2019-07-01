<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(Request $request) {

        $query = DB::Table('invoices')
            ->select(
                'unities.name', 'invoices.start_date', 'invoices.end_date',
                DB::raw('SUM(horas) as horas'),
                DB::raw('SUM(cobros) as cobros'),
                DB::raw('SUM(cobros*precio) as monto')
            )
            ->join('unities', 'unities.id', '=', 'invoices.id_unity')
            ->where('invoices.state','1')
            ->groupBy('invoices.id_unity', 'invoices.start_date', 'invoices.end_date')
            ->get();

        return view('charts.index', compact('query'));
    }

    public function raura(Request $request) {
        return view('charts.raura');
    }

    public function sanrafael(Request $request) {
        return view('charts.san-rafael');
    }

    public function pucamarca(Request $request) {
        return view('charts.pucamarca');
    }
}
