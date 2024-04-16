<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTalent extends Model
{
    use HasFactory;

    protected $table = 'event_talents';

    protected $fillable = [
        'event_id',
        'talent_id',
    ];
}
