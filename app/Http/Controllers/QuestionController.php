<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->view('cms.question.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'question' => 'required|string|min:5|max:100',
            'degree' => 'required|integer|min:1',
            'active' => 'required|boolean',
            '_quiz_id' => 'required|integer|exists:quizzes,id',
        ]);
        //
        if (!$validator->fails()) {
            $question = new Question();
            $question->question = $request->get('question');
            $question->description = $request->get('description');
            $question->degree = $request->get('degree');
            $question->active = $request->get('active');
            $question->quiz_id = $request->get('_quiz_id');
            $isSaved = $question->save();

            $quiz = Quiz::where([
                ['teacher_id', auth('teacher')->user()->id],
                ['id', $request->get('_quiz_id')],
            ])->first();
            if (!is_null($quiz)) {
                $quiz->mark = Question::where('quiz_id', $request->get('_quiz_id'))->sum('degree');
                $_isSaved = $quiz->save();

                $arra_answer = array(
                    $request->get('answer_1'),
                    $request->get('answer_2'),
                    $request->get('answer_3'),
                    $request->get('answer_4'),
                );

                $_is_saved = false;
                $count = 0;
                foreach($arra_answer as $answer) {
                    $new_answer = new Answer();
                    $new_answer->answer = $answer;
                    if ($count == $request->get('correct_answer')) {
                        $new_answer->is_answer = 1;
                    }else {
                        $new_answer->is_answer = 0;
                    }
                    $new_answer->question_id = $question->id;
                    $_is_saved = $new_answer->save();
                    ++$count;
                }

                return response()->json([
                    'message' => $_isSaved && $isSaved && $_is_saved ? 'Question added successfully' : 'Faild to add question',
                ], $_isSaved && $isSaved && $_is_saved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
            }else {
                return redirect()->route('quizzes.index');
            }
        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
