<?php

namespace App\Models;

use App\Http\Controllers\ProductController;
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
    
    // ProductContoroller、18l～部分を持ってきた
    public function getList($request) {
        // Productモデル内で条件を絞る
        $query = self::query();

        // 商品名の検索キーワードがある場合、そのキーワードを含む商品をクエリに追加
        if($search = $request->search){
            $query->where('product_name', 'LIKE', "%{$search}%");
        }
        //companyidに入力したcompany_idを代入。
        $companyid = $request -> input('company_id');
        if($companyid){
            $query->where('company_id', $companyid);
        }

        // 上記の条件(クエリ）のときの5件表示
        $products = $query->paginate(5);

        return $products;
    }


}
