<?php

namespace App\Exports;

use App\Models\Question;
use App\Models\Response;
use App\Models\ResponseAnswer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResponsesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $formId;

    public function __construct($formId)
    {
        $this->formId = $formId;
    }

    public function collection()
    {
        return Response::where('form_id', $this->formId)
                        ->with('responseAnswers.question')
                        ->get();
    }

    // Định nghĩa tiêu đề cột trong file Excel
    public function headings(): array
    {
        $questions = Question::where('form_id', $this->formId)->get();
        $headings = ['Mã sinh viên'];

        foreach($questions as $question) {
            $headings[] = $question->text;
        }

        return $headings;
        
    }

    public function map($response): array
    {
        // Tạo hàng cho mỗi sinh viên với mã sinh viên và câu trả lời tương ứng
        $row = [$response->student_id]; // Mã sinh viên

         $questions = Question::where('form_id', $this->formId)->orderBy('id')->get();
        foreach ($questions as $question) {
            $answer = $response->responseAnswers->where('question_id', $question->id)->first();
            $row[] = $answer ? ($answer->answer ? $answer->answer->text : $answer->answer_text) : ''; // Nội dung câu trả lời
        }

        return $row;
    }
}
