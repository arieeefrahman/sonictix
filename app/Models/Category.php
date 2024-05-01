<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'price',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_categories', 'category_id', 'event_id')->withPivot('ticketStock');
    }

    public static function rules($id = null)
    {
        $createRules = [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
        ];

        $updateRules = [
            'name' => ['sometimes', 'string', 'max:255'],
            'price' => ['sometimes', 'numeric'],
        ];

        return ($id === null) ? $createRules : $updateRules;
    }
}
