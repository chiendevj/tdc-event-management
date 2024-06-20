<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id',
        'email',
        'fullname',
        'classname',
        'conduct_score',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
