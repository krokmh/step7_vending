@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報一覧画面</h1>

    {{-- 検索欄 --}}
    <div class="search mt-5">
        
        <!-- 検索フォーム：GETメソッドで、商品一覧のルートにデータを送信 -->
        <form method="GET" action="{{ route('products.index') }}" id="#serch-form" class="row g-3">

            {{-- 商品名検索用の入力欄 --}}
            <div class="col-sm-12 col-md-3">
                <input type="text" name="search" class="form-control" placeholder="商品名" value="{{ request('search') }}">
            </div>

            {{-- メーカー名セレクトボックス --}}
            {{-- <form method="POST" action="{{ route('products.index') }}"> --}}
            <div class="mb-3">
                <select class="form-select" name="company_id">
                    <option value="">メーカー名</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                    @endforeach
                </select>
            </div>


            <!-- 最小価格の入力欄 -->
            <div class="col-sm-12 col-md-2">
                <input type="number" name="min_price" class="form-control" placeholder="最小価格" value="{{ request('min_price') }}">
            </div>
            <!-- 最大価格の入力欄 -->
            <div class="col-sm-12 col-md-2">
                <input type="number" name="max_price" class="form-control" placeholder="最大価格" value="{{ request('max_price') }}">
            </div>

            <!-- 最小在庫数の入力欄 -->
            <div class="col-sm-12 col-md-2">
                <input type="number" name="min_stock" class="form-control" placeholder="最小在庫" value="{{ request('min_stock') }}">
            </div>
            <!-- 最大在庫数の入力欄 -->
            <div class="col-sm-12 col-md-2">
                <input type="number" name="max_stock" class="form-control" placeholder="最大在庫" value="{{ request('max_stock') }}">
            </div>

            
            {{-- ボタンを押す⇒内容を絞り込み --}}
            <div class="col-sm-12 col-md-1">
                {{-- step8 （１）search-btnをclass名に変更 --}}
                <button  class="search-btn btn btn-outline-secondary" type="submit">検索</button>
            </div>
        </form>
    </div>

    <a href="{{ route('products.create') }}" class="btn btn-warning mb-3">商品新規登録</a>

    <h2>商品情報</h2>
    <div id="#products-table" class="products card mt-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>@sortablelink('id', 'ID')</th>
                    <th>商品画像</th>
                    <th>@sortablelink('product_name', '商品名')</th>
                    <th>
                        @sortablelink('price', '価格')
                        {{-- <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'asc']) }}">↑</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'desc']) }}">↓</a> --}}
                    </th>
                    <th>
                        @sortablelink('stock', '在庫数')
                        {{-- <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => 'asc']) }}">↑</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => 'desc']) }}">↓</a> --}}
                    </th>
                    {{-- <th>@sortablelink('company->company_name', 'メーカー')</th> --}}
                    <th>@sortablelink('company_id', 'メーカー')</th>    {{-- (３) --}}
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->company->company_name }}</td>
                    {{-- <td>{{ $product->comment }}</td> --}}

                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細表示</a>
                        {{-- <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm mx-1">編集</a> --}}

                        {{-- データの削除 --}}
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline id">
                            @csrf
                            @method('DELETE')
                            {{-- step8（４）delete-btnをclass名にする --}}
                            <button type="submit" class="delete-btn btn btn-danger btn-sm mx-1">削除</button>
                            {{-- <input data-user_id="{{$user->id}}" type="submit" class="delete-btn btn btn-danger btn-sm mx-1" value="削除"> --}}
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{-- ページネーション --}}
    {{-- {{ $products->links() }}  --}}
    {{ $products->appends(request()->query())->links() }}

</div>
@endsection
