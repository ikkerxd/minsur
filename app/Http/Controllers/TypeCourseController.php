<?php

namespace App\Http\Controllers;

use App\TypeCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TypeCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:type_courses.create')->only(['create', 'store']);
        $this->middleware('permission:type_courses.index')->only('index');
        $this->middleware('permission:type_courses.edit')->only(['edit', 'update']);
        $this->middleware('permission:type_courses.show')->only('show');
        $this->middleware('permission:type_courses.destroy')->only('destroy');
    }
    
    public function index()
    {
        // $type_courses = TypeCourse::paginate();
        $user = Auth::user();
        $type_courses = DB::table('type_courses')
        ->where('id_unity',$user->id_unity)
        ->get();
        return view('type_courses.index',compact('type_courses'));
    }

    public function create()
    {
        return view('type_courses.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $company = new TypeCourse;
        $company->name = $request->name;
        $company->state = 0;
        $company->id_unity = $user->id_unity;
        $company->save();

        return redirect()->route('type_courses.index')->with('success','El tipo de curso fue registrada');
    }

    public function show(TypeCourse $type_course)
    {
        return view('type_courses.show',compact('type_course'));
    }

    
    public function edit(TypeCourse $type_course)
    {        
        return view('type_courses.edit',compact('type_course'));
    }

    
    public function update(Request $request, $id)
    {
        $type_course = TypeCourse::find($id);
        $type_course->name= $request->name;         
        $type_course->save();

        return redirect()->route('type_courses.index')->with('success','El tipo de curso fue actualizada');
    }

    
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {            
            $type_course = \App\TypeCourse::find($id);
            $type_course->delete();  
            return response()->json([                
                'success'   => $type_course->name.' fue eliminado.',
            ]);          
        }
    }
}
