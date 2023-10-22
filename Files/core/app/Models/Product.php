<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'image' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sells()
    {
        return $this->hasMany(Sell::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
