<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'product_type_id'];

    public function productType()
    {
        return $this->belongsTo('App\Models\ProductType', 'product_type_id');
    }
}
