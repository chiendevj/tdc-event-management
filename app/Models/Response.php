<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    public function form() {
        return $this->belongsTo(Form::class);
    }

    public function responseAnswers() {
        return $this->hasMany(ResponseAnswer::class);
    }
}
