<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talents extends Model
{
    use HasFactory;

    protected $table = 'talents';

    protected $fillable = [
        'stage_name',
        'real_name',
        'image_url'
    ];
}
