<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Order;
use App\Models\Gallery;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'sale_price',
        'user_id',
        'is_variable',
        'image',
        'slug',
        'gallery',
    ];

     protected $casts = [
        'gallery' => 'array', // Cast the gallery attribute to an array
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    } 

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class); // Assuming the User model represents sellers
    }


    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

      
}
