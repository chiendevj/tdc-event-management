<?php
namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $events;

    public function __construct($eventIds)
    {
        $this->events = Event::whereIn('id', $eventIds)->withCount('students')->get();
    }

    public function collection()
    {
        // Fetch data for export (example: students of the event)
        return $this->events->map(function ($event) {
            return [
                'id' => $event->id,
                'name' => $event->name,
                'start_date' => $event->event_start,
                'end_date' => $event->event_end,
                'location' => $event->location,
                'point' => $event->point,
                'registration_open_date' => $event->registration_start,
                'registration_close_date' => $event->registration_end,
                'registered_students' => $event->registration_count,
                'participating_students' => $event->students_count,
                'status' => $event->status,
                'created_at' => $event->created_at,
                'updated_at' => $event->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        // Define headings for the exported file
        return [
            'Mã sự kiện',
            'Tên sự kiện',
            'Ngày bắt đầu',
            'Ngày kết thúc',
            'Địa điểm',
            'Điểm tham gia sự kiện',
            'Ngày mở đăng ký',
            'Ngày đóng đăng ký',
            'Số lượng sinh viên đăng ký tham gia',
            'Số lượng sinh viên tham gia',
            'Trạng thái',
            'Ngày tạo',
            'Ngày cập nhật',
        ];
    }
}

