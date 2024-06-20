<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

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
        $events = $student->events()->toSql();
        
        // dd($events, $student);
        return response()->json(['events' => $events]);
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
}
