<?php

namespace App\Http\Controllers;

use App\Exports\EventExport;
use App\Exports\EventWithStudentsExport;
use App\Exports\ParticipatedEventsExport;
use App\Exports\StudentRegisterEventExport;
use App\Models\AcademicPeriod;
use App\Models\Event;
use App\Models\EventRegister;
use App\Models\Notification;
use App\Models\Student;
use App\Models\StudentEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    /**
     * Display the form for creating a new event.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboards.admin.events.create');
    }

    /**
     * Retrieve all events.
     *
     * This function retrieves all events from the database and returns them as a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllEvents()
    {
        $events = Event::where('is_trash', "not like", '1')->get();
        return response()->json(["data" => $events, "success" => true, "message" => "Events retrieved successfully."]);
    }

    /**
     * Retrieve a specific event by ID.
     *
     * This function retrieves a specific event from the database based on its ID and returns it as a JSON response.
     *
     * @param int $id The ID of the event.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventById($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(["success" => false, "message" => "Event not found."], 404);
        }

        return response()->json(["data" => $event, "success" => true, "message" => "Event retrieved successfully."]);
    }
    /**
     * Store a newly created event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation rules for the request data
        $rules = [
            'name' => 'required',
            'event_photo' => 'required|image',
            'event_start' => 'required|date',
            'event_end' => 'required|date',
            'location' => 'required',
            'content' => 'required',
            'status' => 'required',
        ];

        // Custom error messages for validation rules
        $messages = [
            'name.required' => 'Vui lòng nhập tên sự kiện.',
            'event_photo.required' => 'Vui lòng thêm ảnh cho sự kiện.',
            'event_photo.image' => 'Ảnh sự kiện không hợp lệ.',
            'event_start.required' => 'Vui lòng chọn thời gian bắt đầu sự kiện.',
            'event_start.date' => 'Định dạng thời gian của ngày bắt đầu sự kiện không hợp lệ.',
            'event_end.required' => 'Vui lòng chọn thời gian kết thúc sự kiện.',
            'event_end.date' => 'Định dạng thời gian của ngày kết thúc sự kiện không hợp lệ.',
            'location.required' => 'Vui lòng nhập địa điểm diễn ra sự kiện.',
            'content.required' => 'Hãy thêm một số nội dung cho sự kiện này.',
            'status.required' => 'Vui lòng chọn trạng thái sự kiện.'
        ];

        // Validate the request data
        $validatedData = $request->validate($rules, $messages);

        // Check if the event end time is before the event start time
        if (strtotime($request->event_end) <= strtotime($request->event_start)) {
            return redirect()->back()
                ->withErrors(['event_end' => 'Thời gian kết thúc sự kiện phải sau thời gian bắt đầu.'])
                ->withInput();
        }

        if (isset($request->registration_start) && !isset($request->registration_end)) {
            return redirect()->back()
                ->withErrors(['registration_end' => 'Vui lòng chọn thời gian kết thúc đăng ký sự kiện.'])
                ->withInput();
        }

        if (!isset($request->registration_start) && isset($request->registration_end)) {
            return redirect()->back()
                ->withErrors(['registration_start' => 'Vui lòng chọn thời gian bắt đầu đăng ký sự kiện.'])
                ->withInput();
        }

        if (isset($request->registration_start) && isset($request->registration_end)) {
            // Valid here
            $validatedData['registration_start'] = $request->registration_start;
            $validatedData['registration_end'] = $request->registration_end;

            // Check if the registration end time is before the registration start time
            if (strtotime($request->registration_end) <= strtotime($request->registration_start)) {
                return redirect()->back()
                    ->withErrors(['registration_end' => 'Thời gian đóng đăng ký tham gia sự kiện phải sau thời gian mở.'])
                    ->withInput();
            }

            // Check if the event start time is before the registration start time
            if (strtotime($request->event_start) <= strtotime($request->registration_start)) {
                return redirect()->back()
                    ->withErrors(['registration_start' => 'Thời gian mở đăng ký sự kiện phải trước thời gian bắt đầu sự kiện.'])
                    ->withInput();
            }
        }



        // Handle the event photo upload
        if ($request->hasFile('event_photo')) {
            $file = $request->file('event_photo');
            $filename = 'img_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/events', $filename, 'public');

            Log::info('Uploaded file name: ' . $filename);
            Log::info('Stored file path: ' . $filePath);

            $validatedData['event_photo'] = '/storage/' . $filePath;
        }

        // Create the event with the validated data
        $event = Event::create($validatedData);

        // Set the registration link for the event
        if ($event) {
            $event->registration_link = url('/su-kien/' . Str::slug($request->name) . '-' . $event->id . '/dangky');

            // Determine the academic year and semester based on the event start date
            $eventStartDate = \Carbon\Carbon::parse($event->event_start);
            $eventMonth = $eventStartDate->month;

            if ($eventMonth >= 9 && $eventMonth <= 12) {
                $semester = 1; // Semester 1
            } elseif ($eventMonth >= 3 && $eventMonth <= 6) {
                $semester = 2; // Semester 2
            } else {
                $semester = "summer"; // Summer Semester
            }

            // Check if the academic period already exists
            $academicPeriod = AcademicPeriod::where('semester', $semester)
                ->where('year', $eventStartDate->year)
                ->first();

            // If the academic period doesn't exist, create a new one
            if ($academicPeriod) {
                $event->academic_period_id = $academicPeriod->id;
            } else {
                $newAcademicPeriod = new AcademicPeriod();
                $newAcademicPeriod->semester = $semester;
                $newAcademicPeriod->year = $eventStartDate->year;
                $newAcademicPeriod->save();
                $event->academic_period_id = $newAcademicPeriod->id;
            }

            // Save the event
            $event->save();
            return redirect()->route('events.index')->with('success', 'Sự kiện đã được tạo thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo sự kiện.');
        }
    }

    /**
     * Display a listing of the events.
     *
     * This method retrieves events from the database using pagination and
     * returns a view that displays the events in the admin dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get event by pagination
        $events = Event::paginate(8);
        return view('dashboards.admin.events.index', ['events' => $events]);
    }

    /**
     * Retrieve upcoming and featured events for the home page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function getHomeEvents(Request $request)
    {
        $upcomingEvents  = Event::where('status', 'like', 'Sắp diễn ra')
            ->where('is_trash', '<>', 1)
            ->get();

        return view('home', compact('upcomingEvents'));
    }

    /**
     * Fetches upcoming events.
     *
     * This method retrieves upcoming events based on the provided request parameters.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the upcoming events.
     */
    public function fetchUpcomingEvents()
    {
        $events = Event::where('status', 'like', 'Sắp diễn ra')->where('is_trash', '<>', 1)->get();
        return response()->json($events);
    }

    /**
     * Fetches featured events.
     *
     * This method retrieves featured events from the database. It selects the events along with the count of students
     * registered for each event. The events are sorted in descending order based on the student count. Only events that
     * are not marked as trash and have a status other than "Đã hủy" are included in the result.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchFeaturedEvents(Request $request)
    {
        $events = Event::select('events.*', DB::raw('COUNT(event_student.student_id) as student_count'))
            ->leftJoin('event_student', 'events.id', '=', 'event_student.event_id')
            ->groupBy('events.id')
            ->orderByDesc('student_count')
            ->where('is_trash', '<>', 1)
            ->where('status', 'Đã diễn ra')
            ->paginate(8, ['*'], 'page');
        return response()->json($events);
    }

    public function getEventBySearch(Request $request)
    {
        $key = '%' . $request->input('key') . '%';
        $events = Event::where('name', 'like', $key)
            ->orWhere('status', 'like', $key)
            ->orWhere('location', 'like', $key)
            ->get();
        return response()->json($events);
    }

    public function getAllEventUser()
    {
        $events = Event::select('events.*')
            ->orderByDesc('event_start')
            ->where('is_trash', '<>', 1)
            ->paginate(9, ['*'], 'page');
        return response()->json($events);
    }

    /**
     * Load more events.
     *
     * This function retrieves a paginated list of events from the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadmore(Request $request)
    {
        $limit = 8;

        $events = Event::orderBy('event_start', 'desc')
            ->where('is_trash', '<>',  1)
            ->paginate($limit, ['*'], 'page', $request->page);


        $events->getCollection()->transform(function ($event) {
            $event->attended_count = $event->students()->count();
            $event->registed_count = $event->eventRegisters()->count();
            $event->code_count = $event->eventCodes()->count();
            return $event;
        });

        return response()->json([
            'data' => $events,
            'success' => true,
            'message' => 'Events retrieved successfully.'
        ]);
    }

    /**
     * Display the specified event.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */

    public function show($id, Request $request)
    {
        $event = Event::find($id);
        $students = Student::join('event_registers', 'event_registers.student_id', '=', 'students.id')
            ->where('event_registers.event_id', $id)
            ->select('students.*')
            ->get();

        $classCounts = Student::join('event_registers', 'event_registers.student_id', '=', 'students.id')
            ->where('event_registers.event_id', $id)
            ->select('students.classname', DB::raw('count(*) as count'))
            ->groupBy('students.classname')
            ->pluck('count', 'students.classname')
            ->toArray();

        // Get total registered students count
        $totalRegisteredCount = DB::table('event_registers')
            ->where('event_id', $id)
            ->count();

        // Get total attended students count
        $totalAttendedCount = DB::table('event_student')
            ->where('event_id', $id)
            ->count();

        $nonce = Str::random(8);

        // Tạo URL giao diện người dùng
        $userFacingUrl = url("/sukien/{$id}");
        return view('dashboards.admin.events.show', [
            'event' => $event,
            'students' => $students,
            'classCounts' => $classCounts,
            'totalRegisteredCount' => $totalRegisteredCount,
            'totalAttendedCount' => $totalAttendedCount
        ])->with('title', $event->name)
            ->with('url', $userFacingUrl)
            ->with('image', url($event->event_photo))
            ->with('nonce', $nonce);
    }




    /**
     * Display the details of an event.
     *
     * @param int $id The ID of the event.
     * @return \Illuminate\View\View The view displaying the event details.
     */
    public function detail($name, $id)
    {
        $event = Event::find($id);
        $registrationCode = QrCode::generate($event->registration_link);
        $upcomingEvents = Event::where('status', 'like', 'Sắp diễn ra')->where('is_trash', '<>', 1)->get();

        return view('detail', [
            'event' => $event,
            'registrationCode' => $registrationCode,
            'upcomingEvents' => $upcomingEvents
        ]);
    }

    /**
     * Search for events based on the provided filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // Retrieve the search query, filter start date, filter end date, and status from the request
        $search = $request->search;
        $filterDateStart = $request->filter_date_start;
        $filterDateEnd = $request->filter_date_end;
        $status = $request->status;

        // Create a new query instance for the Event model
        $query = Event::query();

        // Apply the search filter if a search query is provided
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Apply the filter start date if provided
        if (!empty($filterDateStart)) {
            $query->where('event_start', '>=', $filterDateStart);
        }

        // Apply the filter end date if provided
        if (!empty($filterDateEnd)) {
            $query->where('event_start', '<=', $filterDateEnd);
        }

        // Apply the status filter if provided
        if (!empty($status)) {
            if ($status == 'all') {
                // Get all events except the ones in the trash
                $query->where('is_trash', 'not like', 1);
            } else if ($status == "newest") {
                // Order the events by the creation date in descending order
                $query->orderBy('created_at', 'desc');
            } else if ($status == "oldest") {
                // Order the events by the creation date in ascending order
                $query->orderBy('created_at', 'asc');
            } else if ($status == "featured") {
                // Filter the events to only include featured events
                $query->where('is_featured_event', 1);
            } else {
                // Filter the events by the provided status
                $query->where('status', $status)->where('is_trash', 'not like', 1);
            }
        }

        // Paginate the results with 8 events per page
        $events = $query->paginate(8);

        // Return a JSON response with the retrieved events
        return response()->json([
            'data' => $events,
            'success' => true,
            'message' => 'Events retrieved successfully.'
        ]);
    }

    /**
     * Search for events based on the provided filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchEventsTrash(Request $request)
    {
        // Retrieve the search query, filter start date, filter end date, and status from the request
        $search = $request->search;
        $filterDateStart = $request->filter_date_start;
        $filterDateEnd = $request->filter_date_end;
        $status = $request->status;

        // Create a new query instance for the Event model
        $query = Event::query();

        // Apply the search filter if a search query is provided
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Apply the filter start date if provided
        if (!empty($filterDateStart)) {
            $query->where('event_start', '>=', $filterDateStart);
        }

        // Apply the filter end date if provided
        if (!empty($filterDateEnd)) {
            $query->where('event_start', '<=', $filterDateEnd);
        }

        // Apply the status filter if provided
        if (!empty($status)) {
            if ($status == 'all') {
                // Get all events except the ones in the trash
                $query->where('is_trash', 'like', 1);
            } else if ($status == "newest") {
                // Order the events by the creation date in descending order
                $query->orderBy('created_at', 'desc')->where('is_trash', 'like', 1);
            } else if ($status == "oldest") {
                // Order the events by the creation date in ascending order
                $query->orderBy('created_at', 'asc')->where('is_trash', 'like', 1);;
            } else if ($status == "featured") {
                // Filter the events to only include featured events
                $query->where('is_featured_event', 1)->where('is_trash', 'like', 1);;
            } else {
                // Filter the events by the provided status
                $query->where('status', $status)->where('is_trash', 'like', 1);
            }
        }

        // Paginate the results with 8 events per page
        $events = $query->paginate(8);

        // Return a JSON response with the retrieved events
        return response()->json([
            'data' => $events,
            'success' => true,
            'message' => 'Events retrieved successfully.'
        ]);
    }


    /**
     * Display the form for editing an event.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $event = Event::find($id);
        return view('dashboards.admin.events.edit', ['event' => $event]);
    }

    /**
     * Update an event.
     *
     * This function updates an existing event based on the provided request data and event ID.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @param int $id The ID of the event to be updated.
     * @return \Illuminate\Http\RedirectResponse The redirect response after updating the event.
     */
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
            'content.required' => 'Hãy thêm một số nội dung cho sự kiện này.',
            'status.required' => 'Vui lòng chọn trạng thái sự kiện.'
        ];

        $validatedData = $request->validate($rules, $messages);

        if (strtotime($request->event_end) <= strtotime($request->event_start)) {
            return redirect()->back()
                ->withErrors(['event_end' => 'Thời gian kết thúc sự kiện phải sau thời gian bắt đầu.'])
                ->withInput();
        }

        if (isset($request->registration_start) && !isset($request->registration_end)) {
            return redirect()->back()
                ->withErrors(['registration_end' => 'Vui lòng chọn thời gian kết thúc đăng ký sự kiện.'])
                ->withInput();
        }

        if (!isset($request->registration_start) && isset($request->registration_end)) {
            return redirect()->back()
                ->withErrors(['registration_start' => 'Vui lòng chọn thời gian bắt đầu đăng ký sự kiện.'])
                ->withInput();
        }

        if (isset($request->registration_start) && isset($request->registration_end)) {
            // Valid here
            $validatedData['registration_start'] = $request->registration_start;
            $validatedData['registration_end'] = $request->registration_end;

            // Check if the registration end time is before the registration start time
            if (strtotime($request->registration_end) <= strtotime($request->registration_start)) {
                return redirect()->back()
                    ->withErrors(['registration_end' => 'Thời gian đóng đăng ký tham gia sự kiện phải sau thời gian mở.'])
                    ->withInput();
            }

            // Check if the event start time is before the registration start time
            if (strtotime($request->event_start) <= strtotime($request->registration_start)) {
                return redirect()->back()
                    ->withErrors(['registration_start' => 'Thời gian mở đăng ký sự kiện phải trước thời gian bắt đầu sự kiện.'])
                    ->withInput();
            }
        }

        // Check if the event status is "Đã hủy", then create a notification
        if ($request->status == 'Đã hủy') {
            // Create a notification for the event cancellation
            $notification = new Notification();
            $notification->event_id = $event->id;
            $notification->title = 'Thông báo hủy sự kiện';
            $eventDate = \Carbon\Carbon::parse($request->event_start)->format('d/m/Y');
            $expires = \Carbon\Carbon::parse($request->event_start)->format('m/d/Y');

            $photo = url($event->event_photo);

            $notification->content = "<img src='$photo' alt='Ảnh sự kiện' class='my-4 rounded-lg'/>
            <p>Kính gửi quý thầy cô và các em học sinh,</p>
            <p>Chúng tôi rất tiếc phải thông báo rằng sự kiện <strong>$event->name</strong> dự kiến diễn ra
                vào ngày <strong>$eventDate</strong> tại <strong>Trường Cao Đẳng Công Nghệ Thủ Đức</strong> sẽ bị hủy bỏ do
                <strong>một số lý do ngoài ý muốn.</strong>.</p>
            <p>Chúng tôi xin lỗi về bất kỳ sự bất tiện nào có thể gây ra và rất biết ơn sự thông cảm của quý thầy cô và
                các em học sinh trong tình huống này. Chúng tôi đang làm việc để lên lịch lại sự kiện và sẽ thông báo
                đến mọi người sớm nhất có thể.</p>
            <p>Nếu cần thêm thông tin hoặc có bất kỳ câu hỏi nào, xin vui lòng liên hệ với chúng tôi qua <strong>email:
              eventfit@tdc.edu.vn</strong> hoặc số điện thoại: <strong>(028) 22 158 642, Nội bộ: 309</strong>.</p>
            <p>Một lần nữa, chúng tôi xin chân thành cảm ơn quý thầy cô và các em học sinh đã hiểu và thông cảm.</p>
            <p>Trân trọng,<br>
                <strong>Ban Tổ Chức Sự kiện Khoa Công Nghệ Thông Tin, Trường Cao Đằng Công Nghệ Thủ Đức</strong>
            </p>";

            $notification->expires_at = $expires;
            $notification->save();
        }


        if ($request->hasFile('event_photo')) {
            $file = $request->file('event_photo');
            $filename = 'img_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/events', $filename, 'public');

            $validatedData['event_photo'] = '/storage/' . $filePath;
        }

        $eventStartDate = \Carbon\Carbon::parse($request->event_start);
        $eventMonth = $eventStartDate->month;
        if ($eventMonth >= 9 && $eventMonth <= 12) {
            $semester = 1; // Semester 1
        } elseif ($eventMonth >= 3 && $eventMonth <= 6) {
            $semester = 2; // Semester 2
        } else {
            $semester = "summer"; // Semester Sumemr
        }

        // Check exists
        $academicPeriod = AcademicPeriod::where('semester', $semester)
            ->where('year', $eventStartDate->year)
            ->first();



        if ($academicPeriod) {
            $event->academic_period_id = $academicPeriod->id;
        } else {
            $newAcademicPeriod = new AcademicPeriod();
            $newAcademicPeriod->semester = $semester;
            $newAcademicPeriod->year = $eventStartDate->year;
            $newAcademicPeriod->save();
            $event->academic_period_id = $newAcademicPeriod->id;
        }



        $updated = $event->update($validatedData);


        if ($updated) {
            return redirect()->back()->with('success', 'Sự kiện đã được cập nhật thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật sự kiện.');
        }
    }

    /**
     * Export an event to Excel.
     *
     * @param int $eventId The ID of the event to export.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The Excel file download response.
     */
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

        // Lấy đường dẫn hình ảnh từ event
        $imagePath = $event->event_photo;

        $deleted = $event->delete();

        if ($deleted) {
            if ($imagePath) {
                // Convert đường dẫn thành đường dẫn thực trong storage
                $imagePath = str_replace('/storage/', '', $imagePath);
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()->back()->with('success', 'Sự kiện đã được xóa thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa sự kiện.');
        }
    }

    /**
     * Export events based on the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * Export the participated events of a student to an Excel file.
     *
     * @param int $studentId The ID of the student.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The response containing the Excel file.
     */
    public function exportParticipantsToExcel($studentId)
    {
        $student = Student::find($studentId);
        return Excel::download(new ParticipatedEventsExport($studentId), "$student->id" . "_$student->fullname" . "_participated_events.xlsx");
    }

    /**
     * Retrieve the participants of an event.
     *
     * @param int $eventId The ID of the event.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the participants' data.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the event with the given ID is not found.
     */
    // public function getParticipants($eventId)
    // {
    //     $event = Event::findOrFail($eventId);
    //     $students = $event->students;
    //     return response()->json(["data" => $students, "success" => true, "message" => "Participants retrieved successfully."]);
    // }

    public function getParticipants($eventId)
    {
        $event = Event::findOrFail($eventId);
        $students = $event->students;

        // Group students by class and count participations
        $classParticipations = $students->groupBy('classname')
            ->map(function ($classGroup) {
                return $classGroup->count();
            });

        $data = $students->map(function ($student) use ($eventId) {
            $registered = DB::table('event_registers')
                ->where('event_id', $eventId)
                ->where('student_id', $student->id)
                ->exists();

            return [
                'student' => $student,
                'registered' => $registered
            ];
        });

        return response()->json([
            "event" => $event,
            "data" => $data,
            "classParticipations" => $classParticipations,
            "success" => true,
            "message" => "Participants retrieved successfully."
        ]);
    }




    /**
     * Move an event to the trash.
     *
     * @param  int  $id  The ID of the event to be moved to the trash.
     * @return \Illuminate\Http\RedirectResponse  A redirect response to the previous page with a success or error message.
     */
    public function moveEventToTrash($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Không tìm thấy sự kiện.');
        }

        $event->is_trash = 1;
        $event->save();

        return redirect()->back()->with('success', 'Sự kiện đã được chuyển vào thùng rác.');
    }

    /**
     * Cancel an event.
     *
     * @param int $id The ID of the event to cancel.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with a success or error message.
     */
    public function cancelEvent($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Không tìm thấy sự kiện.');
        }

        $event->status = 'Đã hủy';
        $event->save();

        // Create a notification for the event cancellation
        $notification = new Notification();
        $notification->event_id = $event->id;
        $notification->title = 'Thông báo hủy sự kiện';
        $eventDate = \Carbon\Carbon::parse($event->event_start)->format('d/m/Y');

        $photo = url($event->event_photo);

        $notification->content = "<img src='$photo' alt='Ảnh sự kiện' class='my-4 rounded-lg'/>
            <p>Kính gửi quý thầy cô và các em học sinh,</p>
            <p>Chúng tôi rất tiếc phải thông báo rằng sự kiện <strong>$event->name</strong> dự kiến diễn ra
                vào ngày <strong>$eventDate</strong> tại <strong>Trường Cao Đẳng Công Nghệ Thủ Đức</strong> sẽ bị hủy bỏ do
                <strong>một số lý do ngoài ý muốn.</strong>.</p>
            <p>Chúng tôi xin lỗi về bất kỳ sự bất tiện nào có thể gây ra và rất biết ơn sự thông cảm của quý thầy cô và
                các em học sinh trong tình huống này. Chúng tôi đang làm việc để lên lịch lại sự kiện và sẽ thông báo
                đến mọi người sớm nhất có thể.</p>
            <p>Nếu cần thêm thông tin hoặc có bất kỳ câu hỏi nào, xin vui lòng liên hệ với chúng tôi qua <strong>email:
              eventfit@tdc.edu.vn</strong> hoặc số điện thoại: <strong>(028) 22 158 642, Nội bộ: 309</strong>.</p>
            <p>Một lần nữa, chúng tôi xin chân thành cảm ơn quý thầy cô và các em học sinh đã hiểu và thông cảm.</p>
            <p>Trân trọng,<br>
                <strong>Ban Tổ Chức Sự kiện Khoa Công Nghệ Thông Tin, Trường Cao Đằng Công Nghệ Thủ Đức</strong>
            </p>";

        $notification->expires_at = $event->event_end;
        $notification->save();

        return redirect()->back()->with('success', 'Sự kiện đã được hủy.');
    }

    /**
     * Display a paginated list of trashed events.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showTrash()
    {
        $events = Event::where('is_trash', 1)->paginate(8);
        return view('dashboards.admin.events.trash', ['events' => $events]);
    }

    /**
     * Retrieve trashed events.
     *
     * This function retrieves trashed events from the database and returns them as a JSON response.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the trashed events.
     */
    public function trash(Request $request)
    {
        $limit = 8;

        $events = Event::orderBy('created_at', 'desc')
            ->where('is_trash', 1)
            ->paginate($limit, ['*'], 'page', $request->page);

        return response()->json([
            'data' => $events,
            'success' => true,
            'message' => 'Events retrieved successfully.'
        ]);
    }

    /**
     * Restore an event from the trash.
     *
     * @param int $id The ID of the event to restore.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with a success or error message.
     */
    public function restoreEventFromTrash($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Không tìm thấy sự kiện.');
        }

        $event->is_trash = 0;
        $event->save();

        return redirect()->back()->with('success', 'Sự kiện đã được khôi phục.');
    }

    /**
     * Marks an event as featured.
     *
     * @param int $id The ID of the event to mark as featured.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with a success or error message.
     */
    public function featuredEvent($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Không tìm thấy sự kiện.');
        }

        // Check if event already featured
        if ($event->is_featured_event) {
            $event->is_featured_event = 0;
            $event->save();
            return redirect()->back()->with('success', 'Hủy đánh dấu sự kiện nổi bật thành công');
        }

        $event->is_featured_event = 1;
        $event->save();

        return redirect()->back()->with('success', 'Đánh dấu sự kiện nổi bật thành công.');
    }

    /**
     * Retrieve featured events.
     *
     * This function retrieves a list of featured events. If there are many featured events,
     * it randomly selects 4 events and returns them as a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFeaturedEvents()
    {
        //  if have many featured events, get random 4 events
        $events = Event::where('is_featured_event', 1)->where('is_trash', '<>', 1)->where('status', '<>', 'Đã hủy')->inRandomOrder()->limit(4)->get();
        return response()->json(["data" => $events, "staus" => "success", "message" => "Featured events retrieved successfully."]);
    }

    /**
     * Retrieve the question of a specific event.
     *
     * @param int $id The ID of the event.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the event question.
     */
    public function getEventQuestion($id)
    {
        $event = Event::find($id);
        $event->eventRegisters()->get();
        return response()->json(["data" => $event->eventRegisters()->get(), "success" => true, "message" => "Question retrieved successfully."]);
    }

    /**
     * Retrieve the registered students for a specific event.
     *
     * @param int $id The ID of the event.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the registered students' data.
     */
    // public function getRegisteredStudents($id)
    // {
    //     $event = Event::find($id);
    //     $students = $event->eventRegisters()->with('student')->get();
    //     return response()->json(["data" => $students, "success" => true, "message" => "Students retrieved successfully."]);
    // }
    public function getRegisteredStudents($eventId)
    {
        $event = Event::findOrFail($eventId);
        $students = $event->eventRegisters()->with('student')->get();

        // Group students by class and count registrations
        $classRegistrations = $students->groupBy('student.classname')
            ->map(function ($classGroup) {
                return $classGroup->count();
            });

        $data = $students->map(function ($student) use ($eventId) {
            $attended  = DB::table('event_student')
                ->where('event_id', $eventId)
                ->where('student_id', $student->student_id)
                ->exists();

            return [
                'student' => $student,
                'attended' => $attended
            ];
        });

        return response()->json([
            "event" => $event,
            "data" => $data,
            "classRegistrations" => $classRegistrations,
            "success" => true,
            "message" => "Participants retrieved successfully."
        ]);
    }


    /**
     * Export the registration data of an event to an Excel file.
     *
     * @param int $eventId The ID of the event.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The Excel file download response.
     */
    public function exportRegisterEventToExcel($eventId)
    {
        $event = Event::find($eventId);
        return Excel::download(new StudentRegisterEventExport($event->id), 'register_event_' . $event->id . '.xlsx');
    }
}
