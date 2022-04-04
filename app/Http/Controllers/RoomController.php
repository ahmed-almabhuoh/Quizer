<?php

namespace App\Http\Controllers;

use App\Models\Room;
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }
}
