<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'],function() 
{
    //api produto
    Route::get('produtos', 'ProductController@index');
    Route::get('produto/{id}', 'ProductController@show');
    Route::post('salvar-produto', 'ProductController@store');
    Route::put('atualizar-produto/{id}', 'ProductController@update');
    Route::delete('excluir-produto/{id}', 'ProductController@destroy');

    //api categoria
    Route::get('categorias', 'CategoryController@index');
    Route::get('categoria/{id}', 'CategoryController@show');
    Route::post('salvar-categoria', 'CategoryController@store');
    Route::put('atualizar-categoria/{id}', 'CategoryController@update');
    Route::delete('excluir-categoria/{id}', 'CategoryController@destroy');
});

