<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;

class QuizApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        // dd($request->all());
        $quiz = new Quiz();
        $quiz->title = $request->title;
        $quiz->description = $request->description;
        $quiz->publish = $request->publish;
        $quiz->save();

        foreach ($request->questions as $question) {
            $questionObj = new Question();
            $questionObj->title = $question['title'];
            $questionObj->is_mandatory = $question['is_mandatory'];
            $questionObj->quiz_id = $quiz->id;
            $questionObj->correct_answers = 0;
            $questionObj->save();
            foreach ($question['answers'] as $answer) {
                $answerObj = new Answer();
                $answerObj->title = $answer['title'];
                $answerObj->is_correct = $answer['is_correct'];
                $answerObj->question_id = $questionObj->id;
                $answerObj->save();
                if($answer['is_correct']) {
                    $questionObj->correct_answers = $answerObj->id;
                    $questionObj->save();
                }
            }
        }

        return [
            "success" => true,
            "error" => false,
            "data" => $quiz 
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quiz = Quiz::where('id', $id)->first();
        $questions = Question::where('quiz_id', $id)->get();
        $data = $quiz;
        $questionList = [];
        foreach($questions as $key => $question) {
            $questionList[$key] = $question->toArray();
            $answers = Answer::where('question_id', $question->id)->get();
            $questionList[$key]['answers'] = $answers->toArray();
        }
        $data['questions'] = $questionList;
        return [
            "success" => true,
            "error" => false,
            "data" => $data
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
