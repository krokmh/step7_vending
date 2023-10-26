<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    // hasMany：１つのモデルが多くのモデルを所有していること
    // Company会社（１）＝Products商品（多s）
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
