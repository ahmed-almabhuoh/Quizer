<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Dotenv\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $students = Student::where([
            ['teacher_id', auth('teacher')->user()->id],
            ['active', '1'],
        ])->latest('created_at')->get();
        return response()->view('cms.student.index', [
            'students' => $students,
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $password = Str::random(8);
        return response()->view('cms.student.create', [
            'password' => $password,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|string|min:3|max:50|unique:students,email',
            'password' => 'required|string|min:8|max:50'
        ]);
        //
        if (!$validator->fails()) {
            $student = new Student();
            $student->name = $request->get('name');
            $student->email = $request->get('email');
            $student->password = Hash::make($request->get('password'));
            $student->teacher_id = auth('teacher')->user()->id;
            $isSaved = $student->save();

            return response()->json([
                'message' => $isSaved ? 'Student created successfully' : 'Faild to create student',
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        if ($student->teacher_id != auth('teacher')->user()->id) {
            return redirect()->route('students.index');
        }
        //
        return response()->view('cms.student.edit', [
            'student' => $student,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        if ($student->teacher_id != auth('teacher')->user()->id) {
            return redirect()->route('students.index');
        }
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|string|min:3|max:50|unique:students,email,' . $student->id,
            'password' => 'required|string|min:8|max:50'
        ]);
        //
        if (!$validator->fails()) {
            $student->name = $request->get('name');
            $student->email = $request->get('email');
            if ($request->get('password') != 'password') {
                $student->password = Hash::make($request->get('password'));
            }
            $student->teacher_id = auth('teacher')->user()->id;
            $isSaved = $student->save();

            return response()->json([
                'message' => $isSaved ? 'Student updated successfully' : 'Faild to update student',
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
