<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Student;
use App\Models\StudentClass;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rooms = Room::where([
            ['active', 1],
            ['teacher_id', auth('teacher')->user()->id]
        ])->latest('created_at')->get();
        return response()->view('cms.room.index', [
            'rooms' => $rooms,
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
        $code = uniqid();
        return response()->view('cms.room.create', [
            'code' => $code,
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
            'description' => 'nullable',
            'active' => 'required|boolean',
        ]);
        //
        if (!$validator->fails()) {
            $room = new Room();
            $room->name = $request->get('name');
            $room->description = $request->get('description');
            $room->code = $request->get('_code');
            $room->active = $request->get('active');
            $room->teacher_id = auth('teacher')->user()->id;
            $isSaved = $room->save();

            return response()->json([
                'message' => $isSaved ? 'Room created successfully' : 'Faild to create room',
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
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        if (auth('teacher')->user()->id != $room->teacher_id) {
            return redirect()->route('rooms.index');
        }
        //
        return response()->view('cms.room.edit', [
            'room' => $room,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        if (auth('teacher')->user()->id != $room->teacher_id) {
            return redirect()->route('rooms.index');
        }
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'description' => 'nullable',
            'active' => 'required|boolean',
        ]);
        //
        if (!$validator->fails()) {
            $room->name = $request->get('name');
            $room->description = $request->get('description');
            $room->active = $request->get('active');
            $room->teacher_id = auth('teacher')->user()->id;
            $isUpdated = $room->save();

            return response()->json([
                'message' => $isUpdated ? 'Room updated successfully' : 'Faild to update room',
            ], $isUpdated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        if (auth('teacher')->user()->id != $room->teacher_id) {
            return redirect()->route('rooms.index');
        }
        //
        if ($room->delete()) {
            return response()->json([
                'icon' => 'success',
                'title' => 'Deleted',
                'text' => 'Room deleted successfully',
            ], Response::HTTP_OK);
        }else {
            return response()->json([
                'icon' => 'error',
                'title' => 'Faild',
                'text' => 'Faild to delete room!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function showAddStudentToClass ($id) {
        $room = Room::where([
            ['id', $id],
            ['teacher_id', auth('teacher')->user()->id],
            ['active', 1],
        ])->first();
        $srudent_class = StudentClass::where([
            ['room_id', $room->id],
        ])->get();
        $students = Student::where([
            ['teacher_id', auth('teacher')->user()->id],
            ['active', 1],
        ])->get();
        return response()->view('cms.room.add-students', [
            'room' => $room,
            'srudent_class' => $srudent_class,
            'students' => $students,
        ]);
    }

    public function addStudentToClass (Request $request, Room $room) {
        $validator = Validator($request->all(), [
            'student_id' => 'required|integer|exists:students,id',
        ]);
        //
        // Remove student from class if exists
        if (StudentClass::where([
            ['student_id', $request->get('student_id')],
            ['room_id', $room->id]
        ])->exists()) {
            if (StudentClass::where([
                ['student_id', $request->get('student_id')],
                ['room_id', $room->id]
            ])->delete()) {
                return response()->json([
                    'message' => 'Reomved successfully',
                ], Response::HTTP_OK);
            }else {
                return response()->json([
                    'message' => 'Faild to reomove',
                ], Response::HTTP_BAD_REQUEST);
            }
        }
        if (!$validator->fails()) {
            $student_class = new StudentClass();
            $student_class->student_id = $request->get('student_id');
            $student_class->room_id = $room->id;
            $isSaved = $student_class->save();

            return response()->json([
                'message' => $isSaved ? 'Student added successfully' : 'Faild to add student to class',
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
