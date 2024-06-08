<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'event_ticket_category_id',
        'quantity',
        'price',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($id = null)
    {
        
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function event_ticket_category(): BelongsTo
    {
        return $this->belongsTo(EventTicketCategory::class, 'event_ticket_category_id', 'id');
    }
}
