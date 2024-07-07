<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegister extends Model
{
    use HasFactory;
    protected $table = 'event_registers';
    protected $fillable = [
        'student_id',
        'event_id',
        'question'
    ];

    public function event() : BelongsTo {
        return $this->belongsTo(Event::class);
    }

    public function student() : BelongsTo {
        return $this->belongsTo(Student::class);
    }
}
