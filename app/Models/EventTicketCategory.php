<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventTicketCategory extends Model
{
    use HasFactory;
    protected $table='event_ticket_categories';
    public $timestamps = true;
    protected $fillable = [
        'event_id',
        'name',
        'price',
        'ticket_stock',
    ];

    public static function rules($id = null)
    {
        $createTicketCategoryRules = [
            '*.event_id'        => ['required', 'numeric'],
            '*.name'            => ['required', 'string', 'min:1', 'max:255'],
            '*.price'           => ['required', 'numeric'],
            '*.ticket_stock'    => ['required', 'numeric'],
        ];
        $updateTicketCategoryRules = [
            'name'          => ['sometimes', 'string', 'min:1', 'max:255'],
            'price'         => ['sometimes', 'numeric'],
            'ticket_stock'  => ['sometimes', 'numeric'],
        ];

        return ($id === null) ? $createTicketCategoryRules : $updateTicketCategoryRules; 
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'event_ticket_category_id', 'id');
    }
}
