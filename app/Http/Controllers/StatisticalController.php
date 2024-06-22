<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class StatisticalController extends Controller
{

    public function index()
    {
        $events = Event::withCount('students')->get();
        return view('dashboards.admin.statisticals.index', ['events' => $events]);
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
