<?php

namespace App\Http\Controllers;

use App\Models\Product; // Productモデルを現在のファイルで使用できる
use App\Models\Company; // Companyモデル
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $変数名 = モデル名::all();全てのデータを取得
        // $productsにProductのテーブルの情報すべてが格納される
        $products = Product::all(); 
        $products = Product::paginate(5);   // 5件表示（ページネーション）

        //検索部分＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
        // Productモデル内で条件を絞る
        $query = Product::query();

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

        // 商品一覧ビューを表示し、取得した商品情報をビューに渡す
        // return view('products.index', ['products' => $products]);

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
        //送られてきたデータをデータベースへ保存
        // ->validate()送信されたデータが条件に合うのか
        $request->validate([
            'product_name' => 'required', //required：必須
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable', //nullable：未入力でもOK
            'img_path' => 'nullable|image|max:2048', // '|'はパイプ：複数指定の区切り
        ]);

        // 新しく商品を作るため、newで新しいインスタンス作成
        $product = new Product([
            'product_name' => $request->get('product_name'),
            'company_id' => $request->get('company_id'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'comment' => $request->get('comment'),
        ]);

        // リクエストに画像が含まれている場合、その画像を保存します。
        if($request->hasFile('img_path')){ 
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        // 作成したデータベースに新しいレコードを保存。
        $product->save();

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
        //情報が揃っているかリクエストの確認
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'required',
            // リクエストに画像も必要かも
        ]);

        // 商品の情報を更新
        // 例：productモデルのproduct_nameをフォームから送られたproduct_nameの値に書き換える
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;

        // 更新した商品を保存
        $product->save();

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
        // 商品の削除
        $product->delete();
        // 処理が終わったら「商品一覧画面」へ戻る
        return redirect('/products');
    }
}
