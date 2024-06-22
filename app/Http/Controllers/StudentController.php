<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function searchEventsByStudent(Request $request)
    {
        $studentId = $request->input('student_id');

        // Tìm sinh viên dựa vào student_id
        $student = Student::find($studentId);

        if (!$student) {
            return response()->json(['error' => 'Không tìm thấy sinh viên có mã số này.'], 404);
        }

        // Lấy danh sách các sự kiện mà sinh viên đã tham gia
        // Lấy danh sách các sự kiện mà sinh viên đã tham gia bằng truy vấn SQL
        $events = DB::table('events')
            ->join('event_student', 'events.id', '=', 'event_student.event_id')
            ->where('event_student.student_id', $studentId)
            ->select('events.*')
            ->get();
        // dd($events, $student);

        if ($events->isEmpty()) {
            return response()->json(['student' => $student, 'events' => []]);
        }
        return response()->json(['student' => $student, 'events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }


    public function dashboard()
    {
        $students = Student::withCount('events')->orderByDesc('events_count')->paginate(20);
        return view('dashboards.admin.students.index', compact('students'));
    }

    /**
     * Get students by event count
     */

    public function getStudentsByEventCount()
    {
        $students = Student::withCount('events')->orderByDesc('events_count')->get();
        return response()->json(["data" => $students, "status" => "success", "message" => "Get students by event count successfully!"]);
    }

    public function getStudentsById($id)
    {
        $student = Student::with(['events' => function ($query) {
            $query->withCount('students as participants_count');
        }])->find($id);

        if (!$student) {
            return response()->json(["data" => null, "status" => "error", "message" => "Student not found!"]);
        }
        $student->events_count = $student->events->count();
        return response()->json(["data" => $student, "status" => "success", "message" => "Get student by id successfully!"]);
    }
}
