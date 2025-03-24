<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'age' => 'required',
            'major' => 'required'

        ], );


        $student = Student::create([
            'name' => $request->name,
            'age' => $request->age,
            'major' => $request->major,
        ]);


        return redirect()->route('student.index')->with('success', 'Student created successfully!');
    }

    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->has('search')) {
            $search = $request->search;
            if (is_numeric($search)) {
                $query->where('id', $search);
            } else {
                $query->where('name', 'like', '%' . $search . '%');
            }
        }

        $students = $query->paginate(10);

        $isAdmin = DB::table('model_has_roles')
            ->where('model_id', auth()->id())
            ->where('model_type', 'App\\Models\\User')
            ->where('role_id', 1) // Assuming role_id = 1 is for Admin
            ->exists();

        return view('student.index', compact('students', 'isAdmin'));
    }
    public function delete(Request $request, Student $student)
    {
        $student->delete();

        return redirect()->route('student.index');
    }
}
