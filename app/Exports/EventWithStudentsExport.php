<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;

class EventWithStudentsExport implements FromCollection
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
        return $event->students; // Adjust this to your actual relationship or data structure
    }

    public function headings(): array
    {
        // Define headings for the exported file
        return [
            'Student Name',
            'Student Email',
            // Add more headings as needed
        ];
    }
}
