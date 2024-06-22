<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventWithStudentsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function collection()
    {
        // Fetch data for export (example: students of the event)
        $event = Event::findOrFail($this->eventId);
        $students = $event->students;
        return $students->map(function ($student) {
            return [
                'id' => $student->id,
                'email' => $student->email,
                'fullname' => $student->fullname,
                'classname' => $student->classname,
            ];
        });
    }

    public function headings(): array
    {
        // Define headings for the exported file
        return [
            'Mã sinh viên',
            'Mail',
            'Họ và tên',
            'Lớp',
        ];
    }
}
