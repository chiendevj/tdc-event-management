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
                WHEN MONTH(events.event_start) BETWEEN 2 AND 8 THEN CONCAT('Học kì 2 (',YEAR(events.event_start) - 1,' - ', YEAR(events.event_start), ')')
                WHEN MONTH(events.event_start) BETWEEN 9 AND 12 THEN CONCAT('Học kì 1 (',YEAR(events.event_start),' - ', YEAR(events.event_start) + 1, ')')
                WHEN MONTH(events.event_start) = 1 THEN CONCAT('Học kì 1 (',YEAR(events.event_start) - 1,' - ', YEAR(events.event_start), ')')
                ELSE 'Unknown'
            END as semester
        "), DB::raw('COUNT(event_student.student_id) as students_count'))
            ->groupBy('events.id')
            ->orderBy('events.event_start', 'ASC');

        // Apply filters
        if ($request->filled('year')) {
            $selectedYear = $request->input('year');
            $startYear = $selectedYear;
            $endYear = $startYear + 1;

            // Adjust the start and end dates based on the academic year
            $startDate = date('Y-m-d', strtotime("$startYear-09-01"));
            $endDate = date('Y-m-d', strtotime("$endYear-08-31"));

            // Apply date range filter
            $query->whereBetween('events.event_start', [$startDate, $endDate]);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
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

        $selectedYear = $request->input('year');
        $search = $request->input('search');

        return view('dashboards.admin.statisticals.index', compact('events', 'years', 'selectedYear', 'search'));
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
}
