<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Room;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::where([
            ['teacher_id', auth('teacher')->user()->id],
            ['active', 1],
        ])
            ->with('room')
            ->get();
        //
        return response()->view('cms.quiz.index', [
            'quizzes' => $quizzes,
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
        $rooms = Room::where([
            ['active', 1],
            ['teacher_id', auth('teacher')->user()->id]
        ])->get();
        return response()->view('cms.quiz.create', [
            'rooms' => $rooms,
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
            'title' => 'required|string|min:3|max:50',
            'mark' => 'required|integer|min:1',
            'time_in_minutes' => 'required|integer|min:1',
            'time' => 'required|string|min:10',
            'room' => 'required|integer|exists:rooms,id',
            'active' => 'required|boolean',
        ]);
        //
        if (!$validator->fails()) {
            $room = Room::find($request->get('room'));
            $quiz = new Quiz();
            $quiz->title = $request->get('title');
            $quiz->description = $request->get('description');
            $quiz->mark = $request->get('mark');
            $quiz->time = $request->get('time_in_minutes');
            $quiz->active = $request->get('active');
            $quiz->teacher_id = auth('teacher')->user()->id;
            $quiz->from = date_format(Carbon::make($request->get('time')),'y-m-d H:i');
            $quiz->room_id = $request->get('room');
            $quiz->percentage = 0.0;
            $isSaved = $quiz->save();

            return response()->json([
                'message' => $isSaved ? 'Quiz added successfully to ' . $room->name . ' room.' : 'Faild to add quiz to the room.',
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
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        if ($quiz->teacher_id != auth('teacher')->user()->id) {
            return redirect()->route('quizzes.index');
        }
        //
        $rooms = Room::where([
            ['active', 1],
            ['teacher_id', auth('teacher')->user()->id],
        ])->get();
        return response()->view('cms.quiz.edit', [
            'quiz' => $quiz,
            'rooms' => $rooms,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        if ($quiz->teacher_id != auth('teacher')->user()->id) {
            return redirect()->route('quizzes.index');
        }
        $validator = Validator($request->all(), [
            'title' => 'required|string|min:3|max:50',
            'mark' => 'required|integer|min:1',
            'time_in_minutes' => 'required|integer|min:1',
            'time' => 'required|string|min:10',
            'room' => 'required|integer|exists:rooms,id',
            'active' => 'required|boolean',
        ]);
        //
        if (!$validator->fails()) {
            $quiz->title = $request->get('title');
            $quiz->description = $request->get('description');
            $quiz->mark = $request->get('mark');
            $quiz->time = $request->get('time_in_minutes');
            $quiz->active = $request->get('active');
            $quiz->teacher_id = auth('teacher')->user()->id;
            $quiz->from = date_format(Carbon::make($request->get('time')),'y-m-d H:i');
            $quiz->room_id = $request->get('room');
            $quiz->percentage = 0.0;
            $isSaved = $quiz->save();

            return response()->json([
                'message' => $isSaved ? 'Quiz updated successfully' : 'Faild to update quiz',
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
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        if ($quiz->teacher_id != auth('teacher')->user()->id) {
            return redirect()->route('quizzes.index');
        }
        //
        if ($quiz->delete()) {
            return response()->json([
                'icon' => 'success',
                'title' => 'Deleted',
                'text' => 'Quiz romved successfully.',
            ], Response::HTTP_OK);
        }else {
            return response()->json([
                'icon' => 'error',
                'title' => 'Faild!',
                'text' => 'Quiz faild to romve.',
            ], Response::HTTP_OK);
        }
    }

    public function addQuestionToQuiz ($id) {
        $quiz = Quiz::where([
            ['id', $id],
            ['active', 1],
            ['teacher_id', auth('teacher')->user()->id],
        ])->first();
        return response()->view('cms.question.create', [
            'quiz' => $quiz,
        ]);
    }

    public function getToQuizQuestions ($id) {
        $quiz = Quiz::where('id', $id)->with('questions')->withCount('questions')->first();
        if ($quiz->teacher_id != auth('teacher')->user()->id) {
            return redirect()->route('quizzes.index');
        }else {
            return response()->view('cms.question.index', [
                'quiz' => $quiz,
            ]);
        }
    }
}
