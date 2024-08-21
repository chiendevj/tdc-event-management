<?php

namespace App\Http\Controllers;

use App\Exports\ResponsesExport;
use App\Models\Answer;
use App\Models\Event;
use App\Models\Form;
use App\Models\Question;
use App\Models\Response;
use App\Models\ResponseAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class FormController extends Controller
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
    public function create($id)
    {
        // Tìm form dựa trên event_id
        $form = Form::where('event_id', $id)->first(['id']);

        // Tìm event dựa trên id và lấy tên sự kiện
        $event = Event::find($id, ['name']);

        if ($form) {
            // Lấy các câu hỏi liên kết với form
            $questions = Question::where('form_id',  $form->id)->with('answers')->orderBy('id')->get();

            // Truyền thêm 'event_name' vào view
            return view('dashboards.admin.question-form.create', [
                'id' => $id,
                'form_id' => $form->id,
                'questions' => $questions,
                'event_name' => $event->name
            ]);
        } else {
            // Truyền thêm 'event_name' vào view
            return view('dashboards.admin.question-form.create', [
                'id' => $id,
                'form_id' => null,
                'event_name' => $event->name
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $eventId = $request->input('event_id');
        $form  = new Form();
        $form->event_id = $eventId;
        $form->save();
        return redirect()->route('event.create.form', ['id' => $eventId, 'form_id' => $form->id])
            ->with('success', 'Tạo Form câu hỏi thành công.');
    }

    public function getStatistic($eventId)
    {

        $event = Event::find($eventId, ['name']);

        $form = Form::where('event_id', $eventId)->first();

        $questions = Question::where('form_id', $form->id)->with('answers')->orderBy('id')->get();

        $statistics = [];

        foreach ($questions as $question) {
            //Đếm số lượng trả lời cho câu hỏi này
            $responseCount = ResponseAnswer::where('question_id', $question->id)->count();

            //Đếm số lượng chọn của từng đáp án
            $answerCounts = [];
            $textResponses = [];

            if ($question->type === 'text') {
                // Đối với câu hỏi dạng text, lấy tất cả các câu trả lời text
                $textResponses = ResponseAnswer::where('question_id', $question->id)
                    ->pluck('answer_text');
            } else {
                foreach ($question->answers as $answer) {
                    $count = ResponseAnswer::where('question_id', $question->id)
                        ->where('answer_id', $answer->id)
                        ->count();
                    $answerCounts[$answer->id] = $count;
                }
            }

            $statistics[] = [
                'question' => $question,
                'answers' => $question->answers,
                'response_count' => $responseCount,
                'answers_counts' => $answerCounts,
                'text_responses' => $textResponses
            ];
        }


        return view('dashboards.admin.question-form.statistic', [
            'id' => $eventId,
            'event_name' => $event->name,
            'statistics' => $statistics
        ]);
    }

    // Export excel
    public function export($id) {
        $form = Form::where('event_id', $id)->first(['id']);

        $event = Event::find($id, ['name']);
        $slug = Str::slug($event->name);
        $fileName = $slug . "_responses.xlsx";

        return Excel::download(new ResponsesExport($form->id),  $fileName);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $eventId)
    {
        $form = Form::where('event_id', $eventId)->first();
        
        //Xóa các response và responseAnswer liên quan
        $responses = Response::where('form_id', $form->id)->get();
        foreach($responses as $response) {
            ResponseAnswer::where('response_id', $response->id)->delete();
            $response->delete();
        }

        // Tìm tất cả câu hỏi liên qua đén form 
        $questions = Question::where('form_id', $form->id)->get();
        foreach($questions as $question) {
            //Xóa đáp án
            Answer::where('question_id', $question->id)->delete();
            //Xóa câ hỏi
            $question->delete();
        }

        //Xóa form
        $form->delete();

        return redirect()->route('event.create.form', ['id' => $eventId])->with('success', 'Form và tất cả các liên kết đã được xóa thành công.');;
    }
}
