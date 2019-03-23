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

//Route::any('/', function () {
//    return view('index.index');
//});
//oneinstack
//测试
Route::any( 'test' , 'Test\TestController@test' );
Route::any( 'add' , 'Test\TestController@add' );
Route::any( 'addDo' , 'Test\TestController@addDo' );
Route::any( 'goodsList' , 'Test\TestController@goodsList' );
Route::any( 'delete' , 'Test\TestController@delete' );
Route::any( 'update/{id}' , 'Test\TestController@update' );
Route::any( 'updateDo' , 'Test\TestController@updateDo' );
Route::any('ajaxUpd',"Test\TestController@ajaxUpd");
Route::any('goodsSelect',"Test\TestController@goodsSelect");


//首页
Route::any('/',"Index\IndexController@index");
Route::any('index',"Index\IndexController@index");
Route::any('productList',"Index\IndexController@productList");

//注册
Route::any('register',"Account\AccountController@register");
Route::any('sendCode',"Account\AccountController@sendCode");//发送验证码
Route::any('regauth',"Account\AccountController@regauth");
//登录
Route::any('login',"Account\AccountController@login");
Route::any('userPage',"Account\AccountController@userPage");

//全部商品
Route::any('allShops',"Goods\GoodsController@allShops");
Route::any('shopsList',"Goods\GoodsController@shopsList");

//详情
Route::any('particulars',"Goods\GoodsController@particulars");

//购物车
Route::any('cartAdd',"Cart\CartController@cartAdd");
Route::any('cartList',"Cart\CartController@cartList");
Route::any('cartDelete',"Cart\CartController@cartDelete");
Route::any('cartDeletes',"Cart\CartController@cartDeletes");
Route::any('cart',"Cart\CartController@cart");


//订单
Route::any('orderAdd',"Order\OrderController@orderAdd");
Route::any('orderList',"Order\OrderController@orderList");
Route::any('pay',"Order\OrderController@pay");
Route::any('buyRecord',"Order\OrderController@buyRecord");
//alipay
Route::any('show',"Order\OrderController@show");
//Route::any('showIndex',"Order\OrderController@showIndex");
Route::any('notify',"Order\OrderController@notify");
Route::any('result',"Order\OrderController@result");
Route::any('sync',"Order\OrderController@sync");

//地址
Route::any('writeAddress',"Address\AddressController@writeAddress");
Route::any('addressAdd',"Address\AddressController@addressAdd");
Route::any('address',"Address\AddressController@address");
Route::any('addressUp',"Address\AddressController@addressUp");
Route::any('addressDelete',"Address\AddressController@addressDelete");
Route::any('addressUpdate',"Address\AddressController@addressUpdate");
Route::any('updateDo',"Address\AddressController@updateDo");




//
Route::any('demoList',"Demo\DemoController@demoList");


//微信
Route::any('wechatIndex','Wechat\WechatController@wechatIndex');


Route::any('wxlogin','Account\AccountController@wxlogin');//微信登陆
Route::any('wxlogincode','Account\AccountController@wxlogincode');//网页授权


