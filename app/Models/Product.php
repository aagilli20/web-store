<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['deleted_at'];

    protected $fillable = [
        'name',
        'price',
        'description',
        'stock',
        'status',
        'warranty'
    ];

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')->withPivot('quantity', 'price');
    }

    public function promotions(){
        return $this->hasMany(Promotion::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

}
