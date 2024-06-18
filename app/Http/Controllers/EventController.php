<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        // Define the validation rules
        $rules = [
            'name' => 'required',
            'event_photo' => 'required|image',
            'event_start' => 'required|date',
            'event_end' => 'required|date',
            'location' => 'required',
            'point' => 'required|integer',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date',
        ];

        // Define custom error messages
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
        ];

        // Validate the request with custom messages
        $validatedData = $request->validate($rules, $messages);

        // Check if event_start and event_end are on the same day and within 2 hours
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


        // Handle the event photo upload
        if ($request->hasFile('event_photo')) {
            $file = $request->file('event_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/events', $filename, 'public');

            // Add the event_photo path to the validated data
            $validatedData['event_photo'] = '/storage/' . $filePath;
        }

        // Create the event
        $event = Event::create($validatedData);

        // Back to the previous page with a success message
        // Check if the event was created successfully

        if ($event) {
            return redirect()->back()->with('success', 'Sự kiện đã được tạo thành công.');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo sự kiện.');
        }
    }

    public function index()
    {
        $events = Event::all();
        return view('dashboards.admin.events.index', ['events' => $events]);
    }


    public function show($id)
    {
        $event = Event::find($id);
        return view('dashboards.admin.events.show', ['event' => $event]);
    }


}
