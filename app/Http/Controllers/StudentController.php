<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Dotenv\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
            'email' => 'required|string|min:3|max:50',
            'password' => 'required|string|min:8|max:50'
        ]);
        //
        if (!$validator->fails()) {
            $student = new Student();
            $student->name = $request->get('name');
            $student->email = $request->get('email');
            $student->password = $request->get('password');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
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
        //
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
