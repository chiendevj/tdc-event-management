<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'email',
        'fullname',
        'classname',
        'conduct_score',
        'birth'
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_student', 'student_id', 'event_id')->withTimestamps();
    }

    public function eventCount()
    {
        return $this->events()->count();
    }

    public function eventRegisters()
    {
        return $this->hasMany(EventRegister::class);
    }
}
