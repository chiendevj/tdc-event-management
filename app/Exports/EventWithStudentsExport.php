<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventWithStudentsExport implements FromCollection, WithHeadings
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function collection()
    {
        // Fetch students of the event and select relevant columns
        $event = Event::with('students')->findOrFail($this->eventId);
        return $event->students->map(function($student) {
            return [
                'id' => $student->id,
                'name' => $student->fullname,
                'email' => $student->email,
                'classname' => $student->classname,

            ];
        });
    }

    public function headings(): array
    {
        // Define the headings for the exported file
        return [
            'Mã Số Sinh Viên',
            'Họ và Tên',
            'Địa chỉ Email',
            'Lớp',
        ];
    }
}
