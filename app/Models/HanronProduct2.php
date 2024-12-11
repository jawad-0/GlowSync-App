<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HanronProduct2 extends Model
{
    protected $table = 'hanron_products2';
    protected $fillable = [
        'product_code',
        'parent_code',
        'description',
        'product_name',
        'image_url',
        'option',
        'stock',
        'trade_price',
        'average_weight',
    ];
}
