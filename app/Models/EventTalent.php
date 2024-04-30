<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventTalent extends Pivot
{
    use HasFactory;

    protected $table = 'event_talents';
    public $timestamps = true;

    protected $fillable = [
        'event_id',
        'talent_id',
    ];

    public static function rules($id = null) {
        $createRules = [
            'event_id' => ['required', 'numeric'],
            'talent_id' => ['required', 'numeric'],
        ];

        $updateRules = [
            'event_id' => ['sometimes', 'numeric'],
            'talent_id' => ['sometimes', 'numeric'],
        ];
        return ($id === null) ? $createRules : $updateRules;
    }
}
