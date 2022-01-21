<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasFactory;

    protected $guarded = ['deleted_at'];

    protected $fillable = [
        'product_id',
        'old_price',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
