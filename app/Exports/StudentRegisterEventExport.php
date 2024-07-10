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
        // return the headings for the exported data
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
        $data = $event->eventRegisters()->with('student')->get();
        return $data->map(function ($register) {
            return [
                'Mã sinh viên' => $register->student->id,
                'Tên sinh viên' => $register->student->fullname,
                'Lớp' => $register->student->classname,
                'Nội dung quan tâm, câu hỏi' => $register->question,
            ];
        });
    }
}

