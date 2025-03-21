<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {

        \Log::info('Store Request Data:', $request->all());

        $request->validate([
            'name' => 'required',
            'age' => 'required',
            'major' => 'required'

        ], );

        \Log::info('Validation passed');

        $student = Student::create([
            'name' => $request->name,
            'age' => $request->age,
            'major' => $request->major,
        ]);


        \Log::info('Student created successfully', ['student' => $_POST]);

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

        return view('student.index', compact('students'));
    }
}
