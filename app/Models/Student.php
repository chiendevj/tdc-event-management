<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'email',
        'fullname',
        'classname',
        'conduct_score',
    ];
 

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_student', 'student_id', 'event_id');
    }
}
