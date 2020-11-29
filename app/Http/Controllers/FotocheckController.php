<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fotocheck;
class FotocheckController extends Controller
{
    
    public function index()
    {
        return view('fotocheck.index');
    }

    public function detail_participant()
    {
        return view('fotocheck/detail_participant');
    }
}
