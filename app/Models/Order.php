<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'addressee',
        'address',
        'city',
        'payment_id',
        'verified_by',
        'delivery_time',
        'status',
        'shipping_cost',
        'mail_company',
        'tracking_code'
    ];


    
    public function products() {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('quantity', 'price');
    }

}
