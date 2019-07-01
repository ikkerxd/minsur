<?php

namespace App\Http\Controllers;

use App\Course;
use App\TypeCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:courses.create')->only(['create', 'store']);
        $this->middleware('permission:courses.index')->only('index');
        $this->middleware('permission:courses.edit')->only(['edit', 'update']);
        $this->middleware('permission:courses.show')->only('show');
        $this->middleware('permission:courses.destroy')->only('destroy');
    }
    
    public function index()
    {
        $user = Auth::user();
        //$courses = Course::paginate();  
        $courses =  DB::table('type_courses')
            ->join('courses','courses.id_type_course','=','type_courses.id')
            ->select('courses.id as id','courses.name as nameCourse','hh','courses.required as required','type_courses.name as nameTypeCourse')
            ->where('courses.id_unity', '=', $user->id_unity)
            ->get();
        return view('courses.index',compact('courses'));
    }

    public function create()
    {
        $user = Auth::user();
        $type_courses = DB::table('type_courses')
            ->where('id_unity','=', $user->id_unity)
            ->pluck('name','id');
        return view('courses.create',compact('type_courses'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $course = new Course;
        $course->id_type_course = $request->id_type_course;
        $course->name = $request->name;
        $course->hh = $request->hh;
        $course->price = 13;
        $course->state = 0;
        if ($request->required) {
            $course->required = 1; // pago es unico
        } else {
            $course->required = 0; // el pago es compartido
        }
        $course->id_unity = $user->id_unity;
        $course->validaty = $request->validaty;
        $course->point_min = $request->point_min;

        $course->save();

        return redirect()->route('courses.index')->with('success','El curso fue registrado');
    }

    public function show(Course $course)
    {
        return view('courses.show',compact('course'));
    }

    
    public function edit(Course $course)
    {        
        $type_courses = TypeCourse::pluck('name','id');
        return view('courses.edit',compact('course','type_courses'));
    }

    
    public function update(Request $request, $id)
    {
        $course = Course::find($id);
        $course->id_type_course = $request->id_type_course;
        $course->name = $request->name;
        $course->hh = $request->hh;
        $course->validaty = $request->validaty;
        $course->point_min = $request->point_min;
        if ($request->required) {
            $course->required = 1; // pago es unico
        } else {
            $course->required = 0; // el pago es compartido
        }
        $course->save();

        return redirect()->route('courses.index')->with('success','El curso fue actualizado');
    }

    
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {            
            $course = \App\Course::find($id);
            $course->delete();  
            return response()->json([                
                'success'   => $course->name.' fue eliminado.',
            ]);          
        }
    }
}
