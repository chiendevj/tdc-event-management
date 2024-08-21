<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Form;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $question = new Question();
        $question->text = $request->input('text');
        $question->type = $request->input('type');
        $question->require = $request->input('require');
        $question->form_id = $request->input('form_id');
        $question->save();

        $answers = $request->input('answers', []);

        foreach ($answers as $value) {
            $answer = new Answer();
            $answer->question_id = $question->id;
            $answer->text = $value;
            $answer->save();
        }

        return response()->json(['success' => true, 'question_id' => $question->id ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $question = Question::where('id',  $id)->with('answers')->first();
        return $question;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Tìm câu hỏi theo id
        $question = Question::find($id);

        //Cập nhập thông tin câu hỏi
        $question->text = $request->input('text');
        $question->type = $request->input('type');
        $question->require = $request->input('require');
        $question->form_id = $request->input('form_id');
        $question->save();

        //Cập nhật câu trả lời của đáp án
        $existingAnswers = $question->answers->keyBy('id');
        $answers = $request->input('answers');

        foreach ($answers as $answerData) {
            if (isset($answerData['id'])) {
                // Nếu answer đã có ID, cập nhật nó
                $answer = Answer::find($answerData['id']);
                if ($answer) {
                    $answer->text = $answerData['text'];
                    $answer->save();
                }
            } else {
                $newAnswer = new Answer();
                $newAnswer->question_id = $question->id;
                $newAnswer->text = $answerData['text'];
                $newAnswer->save();
            }
        }

        // Xóa các options không còn trong danh sách cập nhật
        $existingAnswerIds = array_keys($existingAnswers->toArray());
        $inputAnswerIds = array_column($answers, 'id');
        $answersToDelete = array_diff($existingAnswerIds, $inputAnswerIds);
        Answer::destroy($answersToDelete);


        return response()->json(['success' => true, 'value' => $existingAnswers]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::find($id);
        //Xóa đáp án của câu hỏi
        $question->answers()->delete();
        //Xóa câu hỏi
        $question->delete();
        return response()->json(['success' => true]);
    }
}
