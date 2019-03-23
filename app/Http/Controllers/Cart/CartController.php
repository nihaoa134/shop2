<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Model\Cart;
use App\Model\Cate;
use App\Model\Goods;
use App\Model\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CartController extends Controller
{


    //添加购物车
    public function cartAdd( Request $request ){

        $user_info = $request -> session() -> get('user_info');//user_id

        if( empty( $user_info['user_id'] ) ){

            $arr = array(
                'status' => 0,
                'msg' => '小仙女还没有登录呢~'
            );

            return $arr;

        }

        $goods_id = $request -> input('goods_id');

        $goods_data = Goods::where(['goods_id' => $goods_id]) -> first();

        $cart = Cart::where(['goods_id' => $goods_id]) -> first();

        if( $cart ){

            $cartArr = [
                'buy_number' => $cart['buy_number']+1,
                'utime' => time()
            ];

            $res = Cart::where(['goods_id' => $goods_id]) -> update($cartArr);

            if( $res ){

                $arr = array(
                    'status' => 2,
                    'msg' => '添加购物车OK~'
                );

                return $arr;

            }

        }else{

            $cart_arr = [
                'user_id' => $user_info['user_id'],
                'goods_id' => $goods_id,
                'add_price' => $goods_data['goods_selfprice'],
                'buy_number' => 1,
                'status' => 1,
                'ctime' => time()
            ];

            $res = Cart::insert($cart_arr);

            if( $res ){

                $arr = array(
                    'status' => 2,
                    'msg' => '添加购物车OK~'
                );

                return $arr;

            }

        }

//                if( $cart ){
//
//                    $cartArr = [
//                        'buy_number' => $cart['buy_number']+1,
//                        'utime' => time()
//                    ];
//
//                    $res = Cart::where(['goods_id' => $goods_id]) -> update($cartArr);
//
//                    if( $res ){
//
//                        $arr = array(
//                            'status' => 2,
//                            'msg' => '添加购物车OK~'
//                        );
//
//                        return $arr;
//
//                    }
//
//                }else{
//
//                    $cart_arr = [
//                        'user_id' => $user_info['user_id'],
//                        'goods_id' => $goods_id,
//                        'add_price' => $goods_data['goods_selfprice'],
//                        'buy_number' => 1,
//                        'status' => 1,
//                        'ctime' => time()
//                    ];
//
//                    $res = Cart::insert($cart_arr);
//
//                    if( $res ){
//
//                        $arr = array(
//                            'status' => 2,
//                            'msg' => '添加购物车OK~'
//                        );
//
//                        return $arr;
//
//                    }
//
//                }

            }

//        }

//    }


    //列表
    public function cartList( Request $request ){

        $user_info = $request -> session() -> get('user_info');//user_id

        $where = [
            'shop_cart.user_id' => $user_info['user_id'],
            'shop_cart.status' => 1
        ];

        $List = Cart::
            join('shop_goods as g' , 'shop_cart.goods_id','=','g.goods_id')
            -> where($where)
            -> get();

        $goodsList = Goods::where(['status' => 5]) -> get();

        return view('cart.cart') -> with( ['List' => $List , 'goodsList' => $goodsList] );

    }


    //删除
    public function cartDelete( Request $request ){

        $cart_id = $request -> input('cart_id');

        $arr = [
            'status' => 2
        ];

        $res = Cart::where(['cart_id' => $cart_id]) -> update( $arr );

        if( $res ){

            $arr = array(
                'status' => 1,
                'msg' => '小仙女删除成功'
            );

            return $arr;

        }else{

            $arr = array(
                'status' => 0,
                'msg' => '小仙女删除失败'
            );

            return $arr;

        }

    }


    //批删
    public function cartDeletes( Request $request ){

        $cart_id = $request -> input('arr');

        $arr = [
            'status' => 2
        ];

        $cart_res = Cart::whereIn('cart_id' , $cart_id) -> update($arr);

        if( $cart_res ){

            $arr = array(
                'status' => 1,
                'msg' => '小仙女删除成功'
            );

            return $arr;

        }else{

            $arr = array(
                'status' => 0,
                'msg' => '小仙女删除失败'
            );

            return $arr;

        }

    }


    //点击加减号修改数据库
    public function cart( Request $request ){

        $number = $request -> input('number');

        $cart_id = $request -> input('cart_id');

        $goods_id = $request -> input('goods_id');

        $user = $request -> session() -> get('user_info');

        //查询goods表的库存
        $goods_arr = Goods::where(['goods_id' => $goods_id]) -> first();

        $goods_stock = $goods_arr['goods_stock'];

        //查出购买数量
        $where = [
            'user_id' => $user['user_id'],
            'goods_id' => $goods_id
        ];

        $cart_arr = Cart::where($where) -> first();

        $cart_num = $cart_arr['buy_number'];

        //判断库存
        if( $number > $goods_stock ){

            $arr = array(
                'status' => 0,
                'msg' => '小仙女超出最大库存了',
                'num' => $cart_num
            );

            return $arr;
            exit;

        }


        $cart_where = [
            'buy_number' => $number,
            'utime' => time()
        ];

        $where = [
            'cart_id' => $cart_arr -> cart_id,
            'user_id' => $user['user_id'],
            'goods_id' => $goods_id
        ];

        $res = Cart::where($where) -> update($cart_where);

//        dd($res);

    }



}
