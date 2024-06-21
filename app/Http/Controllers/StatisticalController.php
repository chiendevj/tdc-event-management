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
