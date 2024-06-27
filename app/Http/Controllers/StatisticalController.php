<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticalController extends Controller
{

    public function index(Request $request)
    {
        $query = DB::table('events')
            ->leftJoin('event_student', 'events.id', '=', 'event_student.event_id')
            ->select('events.*', DB::raw("
                CASE 
                    WHEN MONTH(events.event_start) BETWEEN 2 AND 8 THEN CONCAT(YEAR(events.event_start) - 1, ' - Học kì 2')
                    WHEN MONTH(events.event_start) BETWEEN 9 AND 12 THEN CONCAT(YEAR(events.event_start), ' - Học kì 1')
                    WHEN MONTH(events.event_start) = 1 THEN CONCAT(YEAR(events.event_start) - 1, ' - Học kì 1')
                    ELSE 'Unknown'
                END as semester
            "), DB::raw('COUNT(event_student.student_id) as students_count'))
            ->groupBy('events.id');
    
        // Apply filters
        if ($request->filled('year')) {
            // Split the selected academic year into its start and end years
            $selectedYear = explode('-', $request->year);
            $startYear = $selectedYear[0];
            $endYear = $selectedYear[0] + 1;
    
            // Adjust the start and end dates based on the academic year
            $startDate = date('Y-m-d', strtotime("$startYear-09-01"));
            $endDate = date('Y-m-d', strtotime("$endYear-08-31"));
    
            // Apply date range filter
            $query->whereBetween('events.event_start', [$startDate, $endDate]);
        }
    
        if ($request->filled('semester')) {
            $semester = $request->semester;
            $this->applySemesterFilter($query, $semester);
        }
    
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('events.name', 'like', '%' . $search . '%')
                    ->orWhere('events.location', 'like', '%' . $search . '%')
                    ->orWhere('events.content', 'like', '%' . $search . '%');
            });
        }
    
        $events = $query->get();
    
        // Fetch years for the filter dropdown
        $years = DB::table('events')
            ->selectRaw('YEAR(event_start) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
    
        $selectedYear = $request->year;
        $selectedSemester = $request->semester;
        $search = $request->search;
    
        return view('dashboards.admin.statisticals.index', compact('events', 'years', 'selectedYear', 'selectedSemester', 'search'));
    }
    

    public function pagination(Request $request)
    {
        $events = Event::withCount('students')->paginate(5);

        if ($request->ajax()) {
            return view('statisticals.events-item', compact('events'))->render();
        }

        return view('dashboards.admin.statisticals.index', compact('events'));
    }

    public function eventDetails($id)
    {
        $event = Event::with(['students' => function ($query) {
            $query->select('students.id', 'students.classname');
        }])->findOrFail($id);

        $classStatistics = $event->students->groupBy('classname')->map->count();

        return response()->json([
            'event' => $event,
            'classStatistics' => $classStatistics,
        ]);
    }

    private function applySemesterFilter($query, $semester)
    {
        $query->where(function ($query) use ($semester) {
            $query->where(function ($query) use ($semester) {
                $query->whereMonth('events.event_start', '>=', 2)
                    ->whereMonth('events.event_start', '<=', 8)
                    ->whereYear('events.event_start', '=', $semester - 1);
            })->orWhere(function ($query) use ($semester) {
                $query->whereMonth('events.event_start', '>=', 9)
                    ->whereMonth('events.event_start', '<=', 12)
                    ->whereYear('events.event_start', '=', $semester == 1 ? $semester : $semester - 1);
            });
        });
    }
    

}
