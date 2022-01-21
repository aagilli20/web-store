<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;

    protected $guarded = ['deleted_at'];

    protected $fillable = [
        'name',
        'url',
        'product_id'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
