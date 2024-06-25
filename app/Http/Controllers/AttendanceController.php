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
        if(!$eventCode || $eventCode->status == 1) {
            return view('form.404');
        }
        
        $event = [
            'id' => $eventCode->event->id,
            'name' =>  $eventCode->event->name,
            'code' =>  $code,
        ];

        return view('form.attendance', ['event' => $event]);

    }

    public function submitAttendance(Request $request) {
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

        

        $student = new Student();
        $student->fullname = $fullname;
        $student->student_id = $studentId;
        $student->classname = $class;
        $student->save();

        StudentEvent::create([
            'student_id' => $student->id,
            'event_id' => $event_id
        ]);

         // Update the status of the event code
         $eventCode = EventCode::where('code', $code)->firstOrFail();
         $eventCode->status = true;
         $eventCode->save();

         return view('form.success');

    }
}
