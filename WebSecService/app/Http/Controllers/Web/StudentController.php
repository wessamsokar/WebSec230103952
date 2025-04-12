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
        $students = Student::all();

        return view('student.index', compact('students'));
    }
    public function delete(Request $request, Student $student)
    {
        $student->delete();

        return redirect()->route('student.index');
    }
}
