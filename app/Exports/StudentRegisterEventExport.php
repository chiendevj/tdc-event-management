<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentRegisterEventExport implements FromCollection, WithHeadings
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function headings(): array
    {
        return [
            'Mã sinh viên',
            'Tên sinh viên',
            'Lớp',
            'Nội dung quan tâm, câu hỏi',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $event = Event::find($this->eventId);

        // Ensure the event exists before proceeding
        if (!$event) {
            return collect(); // Return an empty collection if event not found
        }

        $data = $event->eventRegisters()->with('student')->get();

        return $data->map(function ($register) {
            $student = $register->student;

            return [
                $student ? $student->id : 'N/A',
                $student ? $student->fullname : 'N/A',
                $student ? $student->classname : 'N/A',
                $register->question ?? 'Không có', // Provide a default value if question is null
            ];
        });
    }
}
