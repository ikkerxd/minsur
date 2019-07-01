<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use App\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $companies = DB::table('users')
                        ->select('users.id', 'users.id_unity', 'users.id_company')
                        ->join('role_user','role_user.user_id', '=', 'users.id')
                        ->where('id_unity', $user->id_unity)
                        ->where('role_id', 4)
                        ->count();
        $users = DB::table('users')
            ->select('users.id', 'users.id_unity', 'users.id_company')
            ->join('role_user','role_user.user_id', '=', 'users.id')
            ->where('id_unity', $user->id_unity)
            ->where('role_id', 1)
            ->count();
        $inscriptions = DB::table('inscriptions')
            ->join('locations','inscriptions.id_location','=','locations.id')
            ->join('courses', 'courses.id', '=', 'inscriptions.id_course')
            ->select('inscriptions.id as id','nameCurso','locations.name as nameLocation',
                'startDate','address','time')
            ->where('type',0)
            ->where('startDate','>=',date('2019-04-26'))
            ->where('courses.id_unity', $user->id_unity)
            ->orderBy('startDate','asc')
            ->count();

        $participants = DB::table('users')
            ->select('users.id', 'users.id_unity', 'users.id_company')
            ->join('role_user','role_user.user_id', '=', 'users.id')
            ->where('id_unity', $user->id_unity)
            ->where('role_id', 5)
            ->count();

        
        $detail_order_services =  DB::table('companies')
                        ->join('users','companies.id','=','users.id_company')    
                        ->join('user_inscriptions','users.id','=','user_inscriptions.id_user')
                        ->join('inscriptions','inscriptions.id','=','user_inscriptions.id_inscription')
                        ->join('role_user','role_user.user_id','=','users.id')
                        ->join('courses','courses.id','=','inscriptions.id_course')
                        ->select('ruc','businessName','user_inscriptions.state','user_inscriptions.created_at','courses.name as courseName','inscriptions.startDate as fecha')
                        ->where('role_id','!=',3)
                        ->orderBy('user_inscriptions.created_at','desc')
                        ->paginate(20);
        return view('home',compact('detail_order_services','companies', 'users', 'inscriptions', 'participants'));
    }
}
