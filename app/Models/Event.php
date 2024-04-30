<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'created_by',
        'location',
        'google_maps_url',
        'image'
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($id = null)
    {
        $createRules = [
            'title'             => ['required', 'string', 'max:255'],
            'description'       => ['required', 'string'],
            'start_date'        => ['required', 'date_format:Y-m-d H:i:s'],
            'end_date'          => ['required', 'date_format:Y-m-d H:i:s', 'after:start_date'],
            'created_by'        => ['required', 'string', 'max:255'],
            'location'          => ['required', 'string', 'max:255'],
            'google_maps_url' => [
                'nullable',
                'url',
                'regex:/^https?:\/\/(maps\.app\.goo\.gl\/|www\.google\.com\/maps\/)/i',
            ],
            'image'             => ['nullable', 'image', 'max:2048'],
            'talent_ids' => 'required|array',
            'talent_ids.*' => 'required|numeric|exists:talents,id',
        ];

        $updateRules = [
            'title'             => ['sometimes', 'string', 'max:255'],
            'description'       => ['sometimes', 'string'],
            'start_date'        => ['sometimes', 'date_format:Y-m-d H:i:s'],
            'end_date'          => ['sometimes', 'date_format:Y-m-d H:i:s', 'after:start_date'],
            'created_by'        => ['sometimes', 'string', 'max:255'],
            'location'          => ['sometimes', 'string', 'max:255'],
            'google_maps_url'   => [
                'nullable', 
                'url',
                'regex:/^https?:\/\/(maps\.app\.goo\.gl\/|www\.google\.com\/maps\/)/i',
            ],
            'image'             => ['nullable', 'image', 'max:2048'],
        ];

        return ($id === null) ? $createRules : $updateRules;
    }

    public function talents(): BelongsToMany
    {
        return $this->belongsToMany(Talent::class, 'event_talents', 'event_id', 'talent_id');
    }

    public function eventCategories(): HasMany
    {
        return $this->hasMany(EventCategory::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'event_categories', 'event_id', 'category_id')->withPivot('ticketStock');
    }

    public function getTalentListAttribute()
    {
        return $this->talents->map(function ($talent) {
            return [
                'id' => $talent->id,
                'stage_name' => $talent->stage_name,
            ];
        });
    }
}
