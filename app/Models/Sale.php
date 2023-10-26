<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    // Product商品（１）＝Sales（多s）
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
