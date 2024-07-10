<?php
namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentEventsExport implements FromCollection, WithHeadings
{
    protected $studentId;
    protected $academicPeriodId;

    public function __construct($studentId, $academicPeriodId)
    {
        $this->studentId = $studentId;
        $this->academicPeriodId = $academicPeriodId;
    }

    public function collection()
    {
        return Event::whereHas('students', function($query) {
            $query->where('student_id', $this->studentId);
        })->where('academic_period_id', $this->academicPeriodId)
          ->get(['id', 'name', 'event_start']);
    }

    public function headings(): array
    {
        return [
            'Mã sự kiện',
            'Tên sự kiện',
            'Ngày tham gia',
        ];
    }
}
