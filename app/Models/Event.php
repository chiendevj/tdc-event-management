<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'event_photo',
        'event_start',
        'event_end',
        'location',
        'point',
        'registration_start',
        'registration_end',
        'registration_link',
        'content',
        'status',
        'is_trash',
        'academic_period_id',
    ];

    public function eventRegisters() : HasMany{
        return $this->hasMany(EventRegister::class);
    }

    public function eventCodes() : HasMany{
        return $this->hasMany(EventCode::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'event_student', 'event_id', 'student_id')->withTimestamps();
    }

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class);
    }
}
