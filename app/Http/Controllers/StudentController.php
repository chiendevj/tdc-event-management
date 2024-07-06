<?php

namespace App\Http\Controllers;

use App\Exports\StudentEventsExport;
use App\Models\AcademicPeriod;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
        $courseYear = "all";
        $students = Student::withCount('events')->orderByDesc('events_count')->paginate(20);
        return view('dashboards.admin.students.index', compact('students', 'courseYear'));
    }

    public function filterStudentByCourse($courseYear)
    {
        if ($courseYear == 'all') {
            $students = Student::withCount('events')->orderByDesc('events_count')->paginate(20);
            return view('dashboards.admin.students.index', compact('students', 'courseYear'));
        }

        $students = Student::withCount('events')
            ->whereRaw('LEFT(id, 3) = ?', [$courseYear])
            ->orderByDesc('events_count')
            ->paginate(20);

        return view('dashboards.admin.students.index', compact('students', 'courseYear'));
    }


    /**
     * Get students by event count
     */

    public function getStudentsByEventCount()
    {
        $students = Student::withCount('events')
            ->with('events')
            ->orderByDesc('events_count')
            ->get();

        return response()->json(["data" => $students, "status" => "success", "message" => "Get students by event count successfully!"]);
    }

    public function getStudentsById($id)
    {
        $student = Student::with(['events' => function ($query) {
            $query->withCount('students as participants_count')->with('academicPeriod');
        }])->find($id);

        if (!$student) {
            return response()->json([
                "data" => null,
                "status" => "error",
                "message" => "Student not found!"
            ]);
        }

        $student->events_count = $student->events->count();

        $eventsByAcademicPeriods = $student->events->groupBy(function ($event) {
            $month = \Carbon\Carbon::parse($event->event_start)->month;

            if ($month >= 9 && $month <= 12) {
                return 'Năm học ' . $event->academicPeriod->year . ' - ' . ($event->academicPeriod->year + 1) . ' , Học kỳ 1';
            } elseif ($month >= 3 && $month <= 6) {
                return 'Năm học ' . ($event->academicPeriod->year - 1) . ' - ' . $event->academicPeriod->year . ' , Học kỳ 2';
            } elseif ($month >= 7 && $month <= 8) {
                return 'Năm học ' . ($event->academicPeriod->year - 1) . ' - ' . $event->academicPeriod->year . ' , Học kỳ hè';
            } else {
                return 'Năm học ' . ($event->academicPeriod->year - 1) . ' - ' . $event->academicPeriod->year . ' , Khoảng thời gian nghỉ';
            }
        });


        $result = [];
        foreach ($eventsByAcademicPeriods as $period => $events) {
            $eventList = [];
            foreach ($events as $event) {
                $eventList[] = [
                    'id' => $event->id,
                    'name' => $event->name,
                    'event_start' => $event->event_start,
                    'event_end' => $event->event_end,
                    'participants_count' => $event->participants_count,
                ];
            }
            $academicPeriodId = $events->first()->academicPeriod->id;
            $result[] = [
                'academic_period_id' => $academicPeriodId,
                'academic_period' => $period,
                'events' => $eventList,
            ];
        }

        // $result = collect($result)->sortBy('academic_period_id')->values()->all();

        $student->events_by_academic_period = $result;

        return response()->json([
            "data" => $student,
            "status" => "success",
            "message" => "Get student by id successfully!"
        ]);
    }

    public function exportStudentEvents($studentId, $academicPeriodId)
    {
        $student = Student::find($studentId);
        $academicPeriod = AcademicPeriod::find($academicPeriodId);

        $file = $academicPeriod->year . '-' . $academicPeriod->year + 1 . '_semester_' . $academicPeriod->semester . '_student_' . $student->fullname . '_events.xlsx';

        if (!$student || !$academicPeriod) {
            return response()->json([
                "data" => null,
                "status" => "error",
                "message" => "Student or Academic Period not found!"
            ]);
        }

        return Excel::download(new StudentEventsExport($studentId, $academicPeriodId), $file);
    }
}
