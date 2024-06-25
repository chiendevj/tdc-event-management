<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventCode extends Model
{
    use HasFactory;
    protected $table = 'event_codes';

    public function event() : BelongsTo {
        return $this->belongsTo(Event::class);
    }

}
