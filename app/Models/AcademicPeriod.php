<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicPeriod extends Model
{
    use HasFactory;

    protected $fillable = ['semester', 'year'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
