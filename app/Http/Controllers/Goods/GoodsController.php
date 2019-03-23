<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use App\Model\Cart;
use App\Model\Cate;
use App\Model\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class GoodsController extends Controller
{

    public function allShops(){

        $cateList = Cate::where(['pid' => 0]) -> select() -> get();

        $goodsList = Goods::orderBy('goods_selfprice' , 'desc') -> get();

        return view( 'goods.allShops' ) -> with(['cateList' => $cateList , 'goodsList' => $goodsList]);

    }

    public function shopsList( Request $request ){

        $cate_id = $request -> input('cate_id');

        if( empty( $cate_id ) ){

            $goods_data = Goods::orderBy('goods_selfprice' , 'desc') -> get();

        }else{

            $cate_arr = Cate::where(['pid' => $cate_id]) -> get();

            $id = [];

            foreach( $cate_arr as $k => $v ){

                $id[$k] = $v -> cate_id;

            }

//            var_dump($id);exit;

            $goods_data = Goods::whereIn('cate_id',$id) -> orderBy('goods_selfprice' , 'desc') -> get();

//            dd($goods_data);

        }

        $view = view( 'goods.shopsList',['goods_data' => $goods_data] );

        $data['view'] = response($view) -> getContent();

        return $data;

    }


    //商品详情
    public function particulars( Request $request ){

        $user = $request -> session() -> get('user_info');

        $cart_arr = Cart::where(['user_id' => $user['user_id'] ,'status' => 1]) -> get();

        $cart_count = count($cart_arr);

        $goods_id = $request -> input();

        $goods_List = Goods::where( ['goods_id' => $goods_id] ) -> first();

        return view( 'goods.particulars' ) -> with(['goods_list' => $goods_List , 'cart_count' => $cart_count]);

    }

}
