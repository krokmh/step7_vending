<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController; //ProductController
use Illuminate\Support\Facades\Auth; //　ユーザ認証？？

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        // ログイン状態なら
        return redirect()->route('products.index');
        // 商品一覧ページ（ProductControllerのindexメソッドが処理）へリダイレクト
    } else {
        // ログイン状態でなければログイン画面へリダイレクト
        return redirect()->route('login');
    }

});

Route::get('/products/edit/{id}', function () {
    // redirect関数にパスを指定する方法
    return redirect('/');
});

// auth()　LaravelUiの機能
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductController::class);
});

// ★step8 Ajax非同期
// Route::resource('/index', 'ProductController');
Route::post('/index', [ProductController::class, 'index']);
