<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['deleted_at'];

    protected $fillable = [
        'name',
        'father_category_id',
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }

    public function getChilds(){
        return $this->hasMany(Category::class, 'father_category_id', 'id') ;

    }

}
