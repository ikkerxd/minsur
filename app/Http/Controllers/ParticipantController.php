<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use App\Management;
use Illuminate\Http\Request;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Excel;
use File;


class ParticipantController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users.create')->only(['create', 'store']);
        $this->middleware('permission:users.create')->only(['create']);
        $this->middleware('permission:users.index')->only('index');
        $this->middleware('permission:users.edit')->only(['edit', 'update']);
        $this->middleware('permission:users.show')->only('show');
        $this->middleware('permission:users.destroy')->only('destroy');
    }
    
    public function index()
    {
        
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $id_company = $this->get_id_company();
        $participant = new User();
        $participant->id_company = $id_company;
        $participant->type_document = $request->type_document;
        $participant->dni = $request->dni;
        $participant->firstlastname = $request->firstlastname;
        $participant->secondlastname = $request->secondlastname;
        $participant->name = $request->name;
        $participant->position = $request->position;
        $participant->phone = $request->phone;
        $participant->email = $request->email;
        $participant->password = bcrypt(md5($request->dni));
        $participant->remember_token = null;
        $participant->code_bloqueo = null;
        $participant->medical_exam = $request->medical_exam;
        $participant->id_management = $request->management;
        $participant->superintendence = $request->superintendence;
        $participant->image = null;
        $participant->image_hash = null;
        $participant->birth_date = $request->birth_date;
        $participant->gender = $request->gender;
        $participant->origin = $request->origin;
        $participant->address = $request->address;
        $participant->state = 0;
        $participant->id_user = $user->id;
        $participant->id_unity = $user->id_unity;
        $participant->save();

        $participant->roles()->sync($request->get('roles'));
        return redirect()->route('users')->with('success','El usuario fue registrada');

        // $user = new TypeCourse;
        // $user->name = $request->name;       
        // $user->state = 0;
        // $user->save();

        // return redirect()->route('users.index')->with('success','El usuario fue registrada');
    }

    public function show(User $user)
    {        
        
    }

    
    public function edit(User $user)
    {
        
    }

    
    public function update(Request $request, User $user)
    {
        
    }

    
    public function destroy(User $user)
    {
        
    }

    public function profile()
    {
        
    }
    
}
