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
        // Fetch data for export (example: students of the event)
        $event = Event::findOrFail($this->eventId);
        return $event->students; // Adjust this to your actual relationship or data structure
    }

    public function headings(): array
    {
        // Define the headings for the exported file
        return [
            'Mã số sinh viên',
            'Mail',
            'Họ và tên',
            'Lớp',
            // Add more headings as needed
        ];
    }
}
