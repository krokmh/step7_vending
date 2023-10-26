@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <h2>商品情報編集画面</h2>
                
                {{-- row = 1行 = col12 ?--}}
                <div class="form-group card">
                    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="input-group align-items-center p-3 row">
                            <div class="col-3"><label for="id" class="form-label">商品情報ID</label></div>
                            <div class="col-9">{{ $product->id }}</div>
                        </div>

                        <div class="input-group align-items-center p-3 row">
                            <div class="col-3"><label for="product_name" class="form-label">商品名</label></div>
                            <div class="col-9"><input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" required></div>
                        </div>

                        <div class="input-group align-items-center p-3 row">
                            <label for="company_id" class="form-label col-3">会社</label>
                            <select class="form-select col-9" id="company_id" name="company_id">
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ $product->company_id == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group align-items-center p-3 row">
                            <label for="price" class="form-label col-3">金額</label>
                            <input type="number" class="form-control col-9" id="price" name="price" value="{{ $product->price }}" required>
                        </div>

                        <div class="input-group align-items-center p-3 row">
                            <label for="stock" class="form-label col-3">在庫数</label>
                            <input type="number" class="form-control col-9" id="stock" name="stock" value="{{ $product->stock }}" required>
                        </div>

                        <div class="input-group align-items-center p-3 row">
                            <label for="comment" class="form-label col-3">コメント</label>
                            <textarea id="comment" name="comment" class="form-control col-9" rows="3">{{ $product->comment }}</textarea>
                        </div>

                        <div class="input-group align-items-center p-3 row">
                            <label for="img_path" class="form-label col-3">商品画像:</label>
                            <input id="img_path" type="file" name="img_path" class="form-control col-9">
                            <img src="{{ asset($product->img_path) }}" alt="商品画像" class="product-image">
                        </div>

                        <button type="submit" class="btn btn-warning mx-3">更新</button>
                        <a href="{{ route('products.index') }}" class="btn btn-info mx-3">戻る</a>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
