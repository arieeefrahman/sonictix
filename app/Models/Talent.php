<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Talent extends Model
{
    use HasFactory;
    protected $table = 'talents';
    public $timestamps = false;
    protected $fillable = [
        'stage_name',
        'real_name',
        'image_url'
    ];

    public static function rules($id = null)
    {
        $createRules = [
            'stage_name' => ['required', 'string', 'max:255'],
            'real_name' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'url'],
        ];

        $updateRules = [
            'stage_name' => ['sometimes', 'string', 'max:255'],
            'real_name' => ['sometimes', 'string', 'max:255'],
            'image_url' => ['sometimes', 'url'],
        ];

        return ($id === null) ? $createRules : $updateRules;
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_talents', 'talent_id', 'event_id');
    }
}
