<?php

namespace App\Models;

use App\Http\Controllers\ProductController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable; // Sortableを使ったソート機能のため追加

class Product extends Model
{
    use HasFactory;
    use Sortable;  // Sortableを使ったソート機能のため追加

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
        'img_path'
    ];

    // Sortableを使ったソート機能のため追加
    protected $sortable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment'
        // 'img_path'
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

        // 価格検索部分＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
        // 最小（入力された）価格以上の商品をクエリに追加
        if($min_price = $request->min_price){
            $query->where('price', '>=', $min_price);
        }
        // 最大（入力された）価格以下の商品をクエリに追加
        if($max_price = $request->max_price){
            $query->where('price', '<=', $max_price);
        }
        // 在庫検索部分＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
        // 最小在庫数
        if($min_stock = $request->min_stock){
            $query->where('stock', '>=', $min_stock);
        }
        // 最大在庫数
        if($max_stock = $request->max_stock){
            $query->where('stock', '<=', $max_stock);
        }

        // ソート部分＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
        // ※ソートのパラメータが指定されている場合、そのカラムでソートを行う
        // if($sort = $request->sort){
        //     $direction = $request->direction == 'desc' ? 'desc' : 'asc'; // directionがdescでない場合は、デフォルトでascとする
        //     $query->orderBy($sort, $direction);
        // }

        // 上記の条件(クエリ）のときの5件表示
        $products = $query->paginate(5);

        return $products;
    }


}
