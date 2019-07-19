<?php

namespace App\Http\Controllers;

use App\Course;
use App\TypeCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Excel;


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

    public function reportRequiedCourses() {
        $user = Auth::user();
        $idUnity = $user->id_unity;
        $idCourses = [];
        if ($idUnity == 1) {
            $idCourses = [82];
        }
        if ($idUnity == 2) {
            $idCourses = [];
        }
        if ($idUnity == 3) {
            $idCourses = [81];
        }
        if ($idCourses == []) {
            $participants = [];
            $coursesRequired = [];
        } else {
            // recuperamos los cursos obligatorios
            $coursesRequired = DB::table('courses')->whereIn('id', $idCourses)->get();

            // Recorremos la lista de cursos
            $select = '';
            $i=1;
            foreach ($coursesRequired as $course) {
                $select = $select.'sum(if(TI.id_course = '.$course->id.', 1, NULL)) as "obligatorio'.$i.'",';
                $i++;
            }
            $select = trim($select, ',');

            // consulta de particpantes que aprobobaron algun curos obligatorio
            $subQuery = DB::table('user_inscriptions')
                ->select('user_inscriptions.id_user', 'inscriptions.id_course', 'inscriptions.nameCurso')
                ->distinct()
                ->join('inscriptions', function ($join) use ($idCourses) {
                    $join->on('inscriptions.id', '=', 'user_inscriptions.id_inscription')
                        ->whereIn('inscriptions.id_course', $idCourses);
                })
                ->whereIn('user_inscriptions.state',[0,1])
                ->whereRaw('user_inscriptions.point >= inscriptions.point_min');

            // Consulta del total de prtcipnte y se hace un cruce con los que aprobaron algun curso abligatorio
            $participants = DB::table('courses')
                ->select('users.id', 'users.dni',
                    DB::raw('CONCAT(users.firstlastname," ", users.secondlastname," ",users.name) as participante'),
                    'users.superintendence',
                    DB::raw($select)
                )
                ->crossJoin('users')
                ->join('role_user','users.id', '=', 'role_user.user_id')
                ->leftJoin(DB::raw("({$subQuery->toSql()}) as TI"), function ($join) use($subQuery) {
                    $join->on('users.id', '=', 'TI.id_user')
                        ->on('courses.id', '=', 'TI.id_course')
                        ->addBinding($subQuery->getBindings());
                })
                ->where('users.state', 0)
                ->where('users.id_unity', $user->id_unity)
                ->where('users.id_company', $user->id_company)
                ->where('role_user.role_id', 5)
                ->groupBy('users.id')
                ->orderBy('users.superintendence', 'users.firstlastname')
                ->get();
        }
        return view('courses.required_courses', compact('participants', 'coursesRequired'));
    }

    public function exportRequiedCourses() {
        $user = Auth::user();
        $idUnity = $user->id_unity;
        $idCourses = [];
        if ($idUnity == 1) {
            $idCourses = [82];
        }
        if ($idUnity == 2) {
            $idCourses = [];
        }
        if ($idUnity == 3) {
            $idCourses = [81];
        }
        if ($idCourses == []) {
            $participants = [];
            $coursesRequired = [];
        } else {
            // recuperamos los cursos obligatorios
            $coursesRequired = DB::table('courses')->whereIn('id', $idCourses)->get();

            // Recorremos la lista de cursos
            $select = '';
            $i = 1;
            $header = array('DNI', 'participante', 'Area/Contrata');
            foreach ($coursesRequired as $course) {
                $select = $select . 'if(sum(if(TI.id_course = ' . $course->id . ', 1, 0)), "SI", "NO") as "obligatorio'.$i.'",';
                $i++;
                array_push($header, $course->name);
            }
            $select = trim($select, ',');

            // consulta de particpantes que aprobobaron algun curos obligatorio
            $subQuery = DB::table('user_inscriptions')
                ->select('user_inscriptions.id_user', 'inscriptions.id_course', 'inscriptions.nameCurso')
                ->distinct()
                ->join('inscriptions', function ($join) use ($idCourses) {
                    $join->on('inscriptions.id', '=', 'user_inscriptions.id_inscription')
                        ->whereIn('inscriptions.id_course', $idCourses);
                })
                ->whereIn('user_inscriptions.state', [0, 1])
                ->whereRaw('user_inscriptions.point >= inscriptions.point_min');

            // Consulta del total de prtcipnte y se hace un cruce con los que aprobaron algun curso abligatorio
            $participants = DB::table('courses')
                ->select('users.dni',
                    DB::raw('CONCAT(users.firstlastname," ", users.secondlastname," ",users.name) as participante'),
                    'users.superintendence as area',
                    DB::raw($select)
                )
                ->crossJoin('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->leftJoin(DB::raw("({$subQuery->toSql()}) as TI"), function ($join) use ($subQuery) {
                    $join->on('users.id', '=', 'TI.id_user')
                        ->on('courses.id', '=', 'TI.id_course')
                        ->addBinding($subQuery->getBindings());
                })
                ->where('users.state', 0)
                ->where('users.id_unity', $user->id_unity)
                ->where('users.id_company', $user->id_company)
                ->where('role_user.role_id', 5)
                ->groupBy('users.id')
                ->orderBy('users.superintendence', 'users.firstlastname')
                ->get();
        }

        Excel::Create('Reportes de participantes por curso obligatorio', function ($excel) use($participants, $header) {
            // Set the title
            $excel->setTitle('lista de particpantes');
            // Chain the setters
            $excel->setCreator('IGH Group')
                ->setCompany('IGH');
            // Call them separately
            $excel->setDescription('lista de participantes que aprobaron el curos obligatorio');
            $excel->sheet('lista participante', function ($sheet) use($participants, $header) {

                $sheet->setColumnFormat(array(
                    'A' => '@',
                ));
                $sheet->row(1, $header);
                $i = 2;
                foreach ($participants as $participant){
                    //dd($participant);
                    if($participant->obligatorio1 == 'SI'){
                        $sheet->cell('D'.$i, function($cell){
                            $cell->setBackground('#2ecc71');
                            $cell->setFontColor('#ffffff');
                        });
                    } else {
                        $sheet->cell('D'.$i, function($cell){
                            $cell->setBackground('#e74c3c');
                            $cell->setFontColor('#ffffff');
                        });
                    }
                    $sheet->row($i, array($participant->dni, $participant->participante, $participant->area, $participant->obligatorio1));
                    $i++;
                }
                $sheet->row(1, function($row) {
                    // call cell manipulation methods
                    $row->setBackground('#2980b9');
                    $row->setFontColor('#ecf0f1');
                    $row->setFont(array(
                        'bold' => true
                    ));
                });
            });
        })->export('xlsx');
    }
}
