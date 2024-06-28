<?php

namespace App\Http\Controllers;

use App\Models\EventCode;
use App\Models\Student;
use App\Models\StudentEvent;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
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

        return view('form.attendance', ['event' => $event]);
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

        return view('form.success');
    }
}
