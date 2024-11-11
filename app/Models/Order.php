<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Tracking;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'email',
        'user_id',
        'seller_id',
        'address',
        'city',
        'payment_method',
        'total',
        'tracking_number',
    ];

    /**
     * Get the items associated with the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the product associated with the order.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the tracking details associated with the order.
     */
    public function tracking()
    {
        return $this->hasOne(Tracking::class);
    }

    /**
     * Get the user who placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming you have a User model
    }

    public function seller()
{
    return $this->belongsTo(User::class, 'seller_id'); // Adjust to use seller_id
}
}
