<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEvent extends Model
{
    use HasFactory;
    protected $table = 'student_event';
    protected $fillable = [
        'student_id',
        'event_id',
    ];
}
