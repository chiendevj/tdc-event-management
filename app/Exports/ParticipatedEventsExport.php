<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ParticipatedEventsExport implements FromCollection, WithHeadings
{
    protected $student;
    protected $events;

    public function __construct($studentId)
    {
        // Get student information
        $this->student = Student::find($studentId);
        // Get events that the student has participated in
        $this->events = $this->student->events()->get();
        // dd($this->events);
    }

    public function collection()
    {
        // Fetch data for export
        $data = [];

        foreach ($this->events as $event) {
            // Get the pivot record for the student and event to access created_at
            $pivot = $event->pivot;

            $data[] = [
                'id' => $this->student->id,
                'name' => $this->student->fullname,
                'event_id' => $event->id,
                'event_name' => $event->name,
                'participated_at' => $pivot->created_at->format('Y-m-d H:i:s'), // Format date as needed
            ];
        }

        return new Collection($data);
    }

    public function headings(): array
    {
        // Define headings for the exported file
        return [
            'Mã sinh viên',
            'Tên sinh viên',
            'Mã sự kiện',
            'Tên sự kiện',
            'Ngày tham gia',
        ];
    }
}
