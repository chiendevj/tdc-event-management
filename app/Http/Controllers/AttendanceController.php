<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCode;
use App\Models\EventRegister;
use App\Models\Form;
use App\Models\Question;
use App\Models\Response;
use App\Models\ResponseAnswer;
use App\Models\Student;
use App\Models\StudentEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    // Điểm danh sinh viên
    public function attend($code)
    {
        $eventCode = EventCode::where('code', $code)->with('event')->first();
        if (!$eventCode || $eventCode->status == 1) {
            return view('form.404')->with('error', 'Mã sự kiện này không tồn tại!');
        }

        $event = [
            'id' => $eventCode->event->id,
            'name' =>  $eventCode->event->name,
            'code' =>  $code,
        ];

        // Find the form associated with the event
        $form = Form::where('event_id', $event['id'])->first();

        $questions = $form ? $form->questions()->with('answers')->orderBy('id')->get() : null;

        return view('form.attendance', [
            'event' => $event,
            'questions' => $questions
        ]);
    }

    public function submitAttendance(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
            'class' => 'required|string|max:255',
        ]);

        $fullname = $request->input('fullname');
        $event_id = $request->input('event_id');
        $studentId = $validated['student_id'];
        $class = $validated['class'];
        $code = $request->input('code');

        // Kiểm tra xem sinh viên đã tồn tại hay chưa
        $student = Student::find($studentId);


        if (!$student) {
            // Nếu sinh viên chưa tồn tại, tạo sinh viên mới
            $student = new Student();
            $student->id = $studentId;
            $student->fullname = $fullname;
            $student->classname = $class;
            $student->save();
        }

        // Kiểm tra xem sinh viên đã điểm danh sự kiện này hay chưa
        $existingAttendance = StudentEvent::where('student_id', $studentId)
            ->where('event_id', $event_id)
            ->first();

        if ($existingAttendance) {
            return view('form.404')->with('error', 'Bạn đã điểm danh sự kiện này rồi!');
        }

        // Tạo bản ghi mới trong bảng StudentEvent
        StudentEvent::create([
            'student_id' => $studentId,
            'event_id' => $event_id
        ]);

        // Cập nhật trạng thái của mã sự kiện
        $eventCode = EventCode::where('code', $code)->firstOrFail();
        $eventCode->status = true;
        $eventCode->save();

        //Lưu câu trả lời của sinh viên nếu có
        $response = new Response();
        $response->form_id = $request->input('form_id');
        $response->student_id =  $studentId;
        $response->save();

        $questions = $request->input('questions');
        Log::info($questions);
        foreach ($questions as $question) {
            $question_id = $question['question_id'];

            // For radio/checkbox
            if (isset($question['answers']) && is_array($question['answers'])) {
                foreach ($question['answers'] as $answer_id) {

                    $responseAnswer = new ResponseAnswer();
                    $responseAnswer->response_id = $response->id;
                    $responseAnswer->question_id = $question_id;
                    $responseAnswer->answer_id = $answer_id;
                    $responseAnswer->save();
                }
            }

            // for text
            if (isset($question['answer_text']) && !empty($question['answer_text'])) {
                $responseAnswer = new ResponseAnswer();
                $responseAnswer->response_id = $response->id;
                $responseAnswer->question_id = $question_id;
                $responseAnswer->answer_text = $question['answer_text'];
                $responseAnswer->save();
            }
        }



        return view('form.success', ['title' => "Điểm danh"])->with('success', "Điểm danh thành công");;
    }

    // Sinh viên đăng kí tham gia sự kiện
    public function register($name, $id)
    {
        $event = Event::find($id);
        return view('form.register', ['event' => $event]);
    }

    public function submitRegister(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
            'class' => 'required|string|max:255',
        ]);

        $fullname = $request->input('fullname');
        $event_id = $request->input('event_id');
        $question = $request->input('question');
        $studentId = $validated['student_id'];
        $class = $validated['class'];
        $code = $request->input('code');

        // Kiểm tra xem sinh viên đã tồn tại hay chưa
        $student = Student::find($studentId);


        if (!$student) {
            // Nếu sinh viên chưa tồn tại, tạo sinh viên mới
            $student = new Student();
            $student->id = $studentId;
            $student->fullname = $fullname;
            $student->classname = $class;
            $student->save();
        }

        // Kiểm tra xem sinh viên đã điểm danh sự kiện này hay chưa
        $existingAttendance = EventRegister::where('student_id', $studentId)
            ->where('event_id', $event_id)
            ->first();

        if ($existingAttendance) {
            return view('form.404')->with('error', 'Bạn đã đăng ký sự kiện này rồi!');
        }

        // Tạo bản ghi mới trong bảng StudentEvent
        EventRegister::create([
            'student_id' => $studentId,
            'event_id' => $event_id,
            'question' => $question
        ]);

        return view('form.success', ['title' => "Đăng ký"])->with('success', "Đăng kí thành công");
    }
}
