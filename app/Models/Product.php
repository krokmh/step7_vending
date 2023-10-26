<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // Product商品（１）＝Sales（多s）Productモデルがsalesテーブルとリレーション
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
        
    // Company会社（１）＝Products商品（多s）Productモデルがcompanysテーブルとリレーション
        public function company()
    {
        return $this->belongsTo(Company::class);
    }
        
    // $fillable　情報を編集や追加するため
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];    
}
