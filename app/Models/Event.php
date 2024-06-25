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
        'content',
        'status',
    ];
  
    public function eventCodes() : HasMany{
        return $this->hasMany(EventCode::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'event_student', 'event_id', 'student_id')->withTimestamps();
    }
}
