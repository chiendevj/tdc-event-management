<?php

namespace App\Http\Controllers;

use App\Exports\EventExport;
use App\Exports\EventWithStudentsExport;
use App\Exports\ParticipatedEventsExport;
use App\Models\Event;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    public function create()
    {
        return view('dashboards.admin.events.create');
    }

    public function getAllEvents()
    {
        $events = Event::all();
        return response()->json(["data" => $events, "success" => true, "message" => "Events retrieved successfully."]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'event_photo' => 'required|image',
            'event_start' => 'required|date',
            'event_end' => 'required|date',
            'location' => 'required',
            'point' => 'required|integer',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date',
            'content' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'name.required' => 'Vui lòng nhập tên sự kiện.',
            'event_photo.required' => 'Vui lòng thêm ảnh cho sự kiện.',
            'event_photo.image' => 'Ảnh sự kiện không hợp lệ.',
            'event_start.required' => 'Vui lòng chọn thời gian bắt đầu sự kiện.',
            'event_start.date' => 'Định dạng thời gian của ngày bắt đầu sự kiện không hợp lệ.',
            'event_end.required' => 'Vui lòng chọn thời gian kết thúc sự kiện.',
            'event_end.date' => 'Định dạng thời gian của ngày kết thúc sự kiện không hợp lệ.',
            'location.required' => 'Vui lòng nhập địa điểm diễn ra sự kiện.',
            'point.required' => 'Vui lòng nhập điểm tham gia sự kiện.',
            'point.integer' => 'Điểm tham gia sự kiện phải là một số nguyên.',
            'registration_start.required' => 'Vui lòng chọn thời gian mở đăng ký tham gia sự kiện.',
            'registration_start.date' => 'Định dạng thời gian của thời gian mở đăng ký tham gia sự kiện không hợp lệ.',
            'registration_end.required' => 'Vui lòng chọn thời gian đóng đăng ký tham gia sự kiện.',
            'registration_end.date' => 'Định dạng thời gian của thời gian đóng đăng ký tham gia sự kiện không hợp lệ.',
            'content.required' => 'Hãy thêm một số nội dung cho sự kiện này.',
            'status.required' => 'Vui lòng chọn trạng thái sự kiện.'
        ];

        $validatedData = $request->validate($rules, $messages);

        if (strtotime($request->event_end) <= strtotime($request->event_start)) {
            return redirect()->back()
                ->withErrors(['event_end' => 'Thời gian kết thúc sự kiện phải sau thời gian bắt đầu.'])
                ->withInput();
        }

        if (strtotime($request->registration_end) <= strtotime($request->registration_start)) {
            return redirect()->back()
                ->withErrors(['registration_end' => 'Thời gian đóng đăng ký tham gia sự kiện phải sau thời gian mở.'])
                ->withInput();
        }

        if (strtotime($request->event_start) <= strtotime($request->registration_start)) {
            return redirect()->back()
                ->withErrors(['registration_start' => 'Thời gian mở đăng ký sự kiện phải trước thời gian bắt đầu sự kiện.'])
                ->withInput();
        }


        if ($request->hasFile('event_photo')) {
            $file = $request->file('event_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/events', $filename, 'public');

            $validatedData['event_photo'] = '/storage/' . $filePath;
        }

        $event = Event::create($validatedData);


        if ($event) {
            $event->registration_link = url('/sukien/' . $event->id . '/dangky');
            $event->save();
            return redirect()->back()->with('success', 'Sự kiện đã được tạo thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo sự kiện.');
        }
    }

    public function index()
    {
        // Get event by pagination
        $events = Event::paginate(8);
        return view('dashboards.admin.events.index', ['events' => $events]);
    }

    public function getHomeEvents(Request $request)
    {
        $upcomingEvents  = Event::where('status', 'like', 'Sắp diễn ra')
            ->paginate(2, ['*'], 'upcoming_page');

        $featuredEvents  = Event::select('events.*', DB::raw('COUNT(event_student.student_id) as student_count'))
            ->leftJoin('event_student', 'events.id', '=', 'event_student.event_id')
            ->groupBy('events.id')
            ->orderByDesc('student_count')
            ->paginate(2, ['*'], 'featured_page');

        return view('home', compact('upcomingEvents', 'featuredEvents'));
    }

    public function fetchUpcomingEvents(Request $request)
    {
        $page = $request->input('page', 1);
        $events = Event::where('status', 'like', 'Sắp diễn ra')
            ->paginate(2, ['*'], 'page', $page);

        return response()->json($events);
    }
    public function fetchFeaturedEvents(Request $request)
    {
        $events = Event::select('events.*', DB::raw('COUNT(event_student.student_id) as student_count'))
            ->leftJoin('event_student', 'events.id', '=', 'event_student.event_id')
            ->groupBy('events.id')
            ->orderByDesc('student_count')
            ->paginate(2, ['*'], 'page');
        return response()->json($events);
    }

    public function loadmore(Request $request)
    {
        $limit = 8;
        $events = Event::orderBy('created_at', 'desc')
            ->paginate($limit, ['*'], 'page', $request->page);

        return response()->json([
            'data' => $events,
            'success' => true,
            'message' => 'Events retrieved successfully.'
        ]);
    }

    public function show($id, Request $request)
    {
        $event = Event::find($id);
        $students = Student::where('event_id', $id)
        ->join('event_registers', 'event_registers.student_id', '=', 'students.id')
        ->select('students.*')
        ->get();

        $classCounts = Student::where('event_id', $id)
        ->join('event_registers', 'event_registers.student_id', '=', 'students.id')
        ->select('students.classname', DB::raw('count(*) as count'))
        ->groupBy('students.classname')
        ->pluck('count', 'students.classname')
        ->toArray();

        $nonce = Str::random(8);
        // dd($classCounts);
        return view('dashboards.admin.events.show', ['event' => $event, 'students' => $students, 'classCounts' => $classCounts])->with('title', $event->name)->with('url', $request->url())->with('image', url($event->event_photo))->with('nonce', $nonce);
    }

    public function detail($id) {
        $event = Event::find($id);
        $registrationCode = QrCode::generate($event->registration_link);
        $upcomingEvents = Event::where('status', 'like', 'Sắp diễn ra')->get();
        
        return view('detail', [
            'event' => $event,
            'registrationCode' => $registrationCode,
            'upcomingEvents' => $upcomingEvents
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $filterDateStart = $request->filter_date_start;
        $filterDateEnd = $request->filter_date_end;
        $status = $request->status;

        $query = Event::query();

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if (!empty($filterDateStart)) {
            $query->where('event_start', '>=', $filterDateStart);
        }

        if (!empty($filterDateEnd)) {
            $query->where('event_start', '<=', $filterDateEnd);
        }

        if (!empty($status)) {
            if ($status == 'all') {
                $query->where('status', "<>", $status);
            } else if ($status == "newest") {
                $query->orderBy('created_at', 'desc');
            } else if ($status == "oldest") {
                $query->orderBy('created_at', 'asc');
            } else {
                $query->where('status', $status);
            }
        }

        $events = $query->paginate(8);

        return response()->json([
            'data' => $events,
            'success' => true,
            'message' => 'Events retrieved successfully.'
        ]);
    }

    public function edit($id)
    {
        $event = Event::find($id);
        return view('dashboards.admin.events.edit', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Không tìm thấy sự kiện.');
        }

        $rules = [
            'name' => 'required',
            'event_photo' => 'image',
            'event_start' => 'required|date',
            'event_end' => 'required|date',
            'location' => 'required',
            'point' => 'required|integer',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date',
            'content' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'name.required' => 'Vui lòng nhập tên sự kiện.',
            'event_photo.image' => 'Ảnh sự kiện không hợp lệ.',
            'event_start.required' => 'Vui lòng chọn thời gian bắt đầu sự kiện.',
            'event_start.date' => 'Định dạng thời gian của ngày bắt đầu sự kiện không hợp lệ.',
            'event_end.required' => 'Vui lòng chọn thời gian kết thúc sự kiện.',
            'event_end.date' => 'Định dạng thời gian của ngày kết thúc sự kiện không hợp lệ.',
            'location.required' => 'Vui lòng nhập địa điểm diễn ra sự kiện.',
            'point.required' => 'Vui lòng nhập điểm tham gia sự kiện.',
            'point.integer' => 'Điểm tham gia sự kiện phải là một số nguyên.',
            'registration_start.required' => 'Vui lòng chọn thời gian mở đăng ký tham gia sự kiện.',
            'registration_start.date' => 'Định dạng thời gian của thời gian mở đăng ký tham gia sự kiện không hợp lệ.',
            'registration_end.required' => 'Vui lòng chọn thời gian đóng đăng ký tham gia sự kiện.',
            'registration_end.date' => 'Định dạng thời gian của thời gian đóng đăng ký tham gia sự kiện không hợp lệ.',
            'content.required' => 'Hãy thêm một số nội dung cho sự kiện này.',
            'status.required' => 'Vui lòng chọn trạng thái sự kiện.'
        ];

        $validatedData = $request->validate($rules, $messages);

        if (strtotime($request->event_end) <= strtotime($request->event_start)) {
            return redirect()->back()
                ->withErrors(['event_end' => 'Thời gian kết thúc sự kiện phải sau thời gian bắt đầu.'])
                ->withInput();
        }

        if (strtotime($request->registration_end) <= strtotime($request->registration_start)) {
            return redirect()->back()
                ->withErrors(['registration_end' => 'Thời gian đóng đăng ký tham gia sự kiện phải sau thời gian mở.'])
                ->withInput();
        }

        if (strtotime($request->event_start) <= strtotime($request->registration_start)) {
            return redirect()->back()
                ->withErrors(['registration_start' => 'Thời gian mở đăng ký sự kiện phải trước thời gian bắt đầu sự kiện.'])
                ->withInput();
        }


        if ($request->hasFile('event_photo')) {
            $file = $request->file('event_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/events', $filename, 'public');

            $validatedData['event_photo'] = '/storage/' . $filePath;
        }

        $updated = $event->update($validatedData);


        if ($updated) {
            return redirect()->back()->with('success', 'Sự kiện đã được cập nhật thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật sự kiện.');
        }
    }

    public function exportEventToExcel($eventId)
    {
        $event = Event::findOrFail($eventId);

        return Excel::download(new EventWithStudentsExport($event->id), 'event_' . $event->id . '.xlsx');
    }

    public function delete($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Không tìm thấy sự kiện.');
        }

        $deleted = $event->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Sự kiện đã được xóa thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa sự kiện.');
        }
    }

    public function exportEvents(Request $request)
    {
        $type = $request->type;

        if ($type == 'list') {
            $eventIds = $request->events;
            return Excel::download(new EventExport($eventIds), 'events.xlsx');
        } else if ($type == 'all') {
            // Export all events
            return Excel::download(new EventExport(Event::all()->pluck('id')->toArray()), 'events.xlsx');
        } else {
            return redirect()->back()->with('error', 'Loại xuất file không hợp lệ.');
        }
    }

    public function exportParticipantsToExcel($studentId)
    {
        $student = Student::find($studentId);
        return Excel::download(new ParticipatedEventsExport($studentId), "$student->id" . "_$student->fullname" . "_participated_events.xlsx");
    }

    public function getParticipants($eventId)
    {
        $event = Event::findOrFail($eventId);
        $students = $event->students;
        return response()->json(["data" => $students, "success" => true, "message" => "Participants retrieved successfully."]);
    }
}
