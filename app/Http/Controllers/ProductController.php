<?php

namespace App\Http\Controllers;

use App\Models\Product; // Productモデルを現在のファイルで使用できる
use App\Models\Company;
use Illuminate\Http\Request;    // RequestフォルダにあるCreateRuquest.php
use Illuminate\Support\Facades\DB;  // ★追加

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // step8 ソート機能の追加
        // Product.phpモデルにも追記
        $posts = Product::sortable()->get(); //sortable() を先に宣言

        // $posts = Product::sortable('company_id','asc')->paginate(5);
        // $posts = Product::sortable('product_name','desc')->paginate(5);


        // $companiesなどを定義する前にreturn viewをしてしまっているので、そこで処理が終わってしまって下まで通らず
        // $postsの宣言の下のreturn viewの処理を一度消す→ソートが機能しない

        // $posts = Product::where('is_completed', 0)->sortable()->paginate(10);
        // return view('products.index',['products.index' => $posts]);
        // return view('products.index')->with('products', $posts);
        // return view('products.index', ['products' => $posts]);


        // ★検索部分はProduct.phpモデルへ移動
        $model = new Product(); 
        $products = $model->getList($request);

        // $productsテーブルとcompaniesテーブルの中身がviewファイルで利用できる
        $companies = Company::all();
        //全ての（companies）会社情報を取得、商品編集画面のselectボックス
        return view('products.index',compact('products' ,'companies'));

    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //商品作成画面の選択で会社名が必要、Companyテーブル全ての情報を取得
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ->validate()送信されたデータが条件に合うか、$request->validate([～
        // ★CreateRuquest.phpへ移動

        // （２－１）　更新、削除、★新規作成
        DB::beginTransaction();

        try {
            
            // 新しく商品を作るため、newで新しいインスタンス作成
            $product = new Product([
                'product_name' => $request->get('product_name'),
                'company_id' => $request->get('company_id'),
                'price' => $request->get('price'),
                'stock' => $request->get('stock'),
                'comment' => $request->get('comment'),
                'img_path' => $request->get('img_path'),  //*（２）画像
            ]);

            // リクエストに画像が含まれている場合、その画像を保存します。
            if($request->hasFile('img_path')){ 
                $filename = $request->img_path->getClientOriginalName();
                $filePath = $request->img_path->storeAs('products', $filename, 'public');
                $product->img_path = '/storage/' . $filePath;
            }

            // 作成したデータベースに新しいレコードを保存。
            $product->save();
            DB::commit();

        } catch (\Exception $e) {   //この部分がよく分かっていない
            DB::rollback();
            return back();
        }
            
        
        // 全ての処理が終わったら、商品一覧画面に戻る
        return redirect('products');
        
       

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //自動的に検索し、その結果を $product に割り当て
        return view('products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //商品編集画面で選択式の会社情報
        $companies = Company::all();

        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // ->validate()送信されたデータが条件に合うか、$request->validate([～
        // ★CreateRuquest.phpへ移動

        // （２－１）　★更新、削除、新規作成
        DB::beginTransaction();

         try {
            
            // 商品の情報を更新
            // 例：productモデルのproduct_nameをフォームから送られたproduct_nameの値に書き換える
            $product->product_name = $request->product_name;
            $product->company_id = $request->company_id;    //*（２）
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;

            // リクエストに画像が含まれている場合、その画像を保存します。
            if($request->hasFile('img_path')){ 
                $filename = $request->img_path->getClientOriginalName();
                $filePath = $request->img_path->storeAs('products', $filename, 'public');
                $product->img_path = '/storage/' . $filePath;
            } 

            // 更新した商品を保存
            $product->save();
            DB::commit();

        } catch (\Exception $e) {   //この部分がよく分かっていない
            DB::rollback();
            return back();
        }

        // 全ての処理が終わったら、「商品一覧画面」に戻る
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // （２－１）　更新、★削除、新規作成
        DB::beginTransaction();

         try {

            // 商品の削除
            $product->delete();
            DB::commit();

        } catch (\Exception $e) {   //この部分がよく分かっていない
            DB::rollback();
            return back();
        }

        // 処理が終わったら「商品一覧画面」へ戻る
        return redirect('/products');
    }
}

