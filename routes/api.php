<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SalesController; //追記

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

// Route::get('/sub', [App\Http\Controllers\SalesController::class, 'sub']);

Route::post('/purchase', 'SalesController@purchase'); //追記

// 不要？
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
