<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Tracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'tracking_number',
        'carrier',
        'status',
        'buyer_email',
        'buyer_address',
        'buyer_city',
        'total',
        'payment_method',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
