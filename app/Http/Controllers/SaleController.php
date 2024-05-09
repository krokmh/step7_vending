<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product; // Productモデルを使用
use App\Models\Sale; // Saleモデルを使用

use DB; //★トランザクションの為に追加
// use Illuminate\Support\Facades\DB;


// ★step8　購入処理APIの作成
class SaleController extends Controller
{
    public function purchase(Request $request)
    {
        // ★リクエストの取得や商品の絞り込み、商品の有無処理はトランザクションを行う前に記述（tryの中はなるべくDB処理のみにしたい）
        // リクエストから必要なデータを取得する
        $productId = $request->input('product_id'); // "product_id":送られた値が代入される
        $quantity = $request->input('quantity', 1); // 購入する数を代入 ※1”quantity”というデータが送られていない場合は1を代入
        

        // データベースから対象の商品を検索・取得
        $product = Product::find($productId); // 16行目、product_idを検索

        // 商品が存在しない、または在庫が不足している場合のバリデーション
        if (!$product) {
            return response()->json(['message' => '商品が存在しません'], 404);
        }
        if ($product->stock < $quantity) {
            return response()->json(['message' => '商品が在庫不足です'], 400);
        }


        // ★トランザクション処理
        try {
            DB::beginTransaction(); // ★データベース操作
            

            // 在庫を減少させる
            $product->stock -= $quantity; // $quantity＝購入数　※1：デフォルトで1が代入されてる
            $product->save();


            // Salesテーブルに商品IDと購入日時を記録
            $sale = new Sale([
                'product_id' => $productId,
                // 主キーであるIDと一緒に「created_at」「 updated_at」は自動入力されるため記述の必要なし
            ]);

            $sale->save();
            DB::commit();   // ★必須

        } catch (\Exception $e) {
            DB::rollBack(); // ★例外処理
            return back();
        }

        // 購入出来たとき
        return response()->json(['message' => '購入成功']);

    }
}
