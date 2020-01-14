<?php

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
    return view('welcome');
});
//闭包路由
Route::get('/hello', function () {
    return 'hello';
});
//控制器方法路由
Route::get('/aa','IndexController@test');

//路由视图
Route::view('/bb','hello',['name'=>'张三']);

//Route::view('/login','login');
Route::get('/login','IndexController@login');
Route::post('/dologin','IndexController@dologin');
//支持多种路由的写法
Route::match(['get','post'],'/login','IndexController@login');
Route::any('/login','IndexController@login');

//必填路由
//Route::get('/goods/{id}', function ($id) {
//    echo $id;
//});

//Route::get('/goods/{id}', 'IndexController@goods')->where('id','\d+');

Route::get('/goods/{id}/{name?}', 'IndexController@getgoods')->where('id','\d+');

Route::prefix('brand')->middleware('checklogin')->group(function () {
    Route::get('create', 'BrandController@create');
    Route::post('store', 'BrandController@store');
    Route::get('/', 'BrandController@index');
    Route::get('edit/{id}', 'BrandController@edit');
    Route::post('update/{id}', 'BrandController@update');
    Route::get('del/{id}', 'BrandController@destroy');
    Route::post('del/{id}', 'BrandController@destroy');
    Route::get('checkOnly', 'BrandController@checkOnly');
});
Route::prefix('cate')->middleware('checklogin')->group(function () {
    Route::get('create', 'CategoryController@create');
    Route::post('store', 'CategoryController@store');
    Route::get('/', 'CategoryController@index');
    Route::get('edit/{id}', 'CategoryController@edit');
    Route::post('update/{id}', 'CategoryController@update');
    Route::get('del/{id}', 'CategoryController@destroy');
});


Route::view('/login','admin.login');
Route::post('/dologin','LoginController@dologin');
Route::get('/logout','LoginController@logout');

//Route::resource('brand', 'BrandController');

//考试
//Route::get('/list','StudentController@lists');
//Route::get('/create','StudentController@create');
//Route::post('/store','StudentController@store');


Route::prefix('goods')->group(function () {
    Route::get('create', 'GoodsController@create');
    Route::post('store', 'GoodsController@store');
    Route::get('/', 'GoodsController@index');
    Route::get('edit/{id}', 'GoodsController@edit');
    Route::post('update/{id}', 'GoodsController@update');
    Route::get('del/{id}', 'GoodsController@destroy');
    Route::get('show/{id}', 'GoodsController@show');
    Route::post('addcart', 'GoodsController@addcart');
});
Route::get('cart', 'GoodsController@cart');

//将cookie添加到响应上
Route::get('/set',function(){
    return response('hello')->cookie('name','张三',2);
});
Route::get('/get',function(){
    return request()->cookie('name');
});
//第二种添加cookie
Route::get('/set2',function(){
    Illuminate\Support\Facades\Cookie::queue('name', 'lisi', 1);
    echo request()->cookie('name');
});


Route::get('send', 'GoodsController@send');