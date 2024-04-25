<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SaleController; //追記

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// APIのルールがを書くところ
// 「他のシステム」から、データを取得・送信するための特定のURL（エンドポイント）を指す

// Route::post('/purchase', 'SalesController@purchase'); //追記
// Route::get('ver','API\VerController@index');

// ★step8 購入処理APIの作成
// postman
Route::post('/index', [SaleController::class, 'purchase']); 
