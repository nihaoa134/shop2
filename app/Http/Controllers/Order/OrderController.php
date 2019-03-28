<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Model\Address;
use App\Model\Cart;
use App\Model\Goods;
use App\Model\Order;
use App\Model\Order_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderController extends CommonController
{

    //创建订单
    public function orderAdd( Request $request ){

        $user = $request -> session() -> get('user_info');

        if( empty($user['user_id']) ){

            $arr = array(
                'status' => 0,
                'msg' => '请先登录'
            );

            return $arr;

        }else{

            $str = '012345b67890d123456a789123456789';

            $order_no = substr( str_shuffle( $str ) , rand( 0 , 15 ) , 9 );

            $cart_id = $request -> input('arr');

            $cart_data = Cart::whereIn('cart_id' , $cart_id)
                -> join('shop_goods as g' , 'shop_cart.goods_id','=','g.goods_id')
                -> get()
                -> toArray();

            //总价
            $amount = [];

            foreach( $cart_data as $v ){

                array_push( $amount , $v['buy_number'] * $v['goods_selfprice'] );

            }

            $order_amount = array_sum($amount);

            $order_data = [
                'user_id' => $user['user_id'],
                'order_no' => $order_no,
                'order_amount' => $order_amount,
                'order_paytype' => 1,
                'order_status' => 1,
                'ctime' => time()
            ];

            $order_res = Order::insertGetId($order_data);

            if( is_numeric($order_res) ){

                $arr = [
                    'status' => 2
                ];

                $res = Cart::whereIn('cart_id' , $cart_id) -> update($arr);

                if( $res ){

                    foreach( $cart_data as $v ){

                        $order_detail = [
                            'order_id' => $order_res,
                            'order_no' => $order_no,
                            'user_id' => $user['user_id'],
                            'goods_id' => $v['goods_id'],
                            'buy_number' => $v['buy_number'],
                            'goods_name' => $v['goods_name'],
                            'goods_price' => $v['goods_selfprice'],
                            'status' => 1,
                            'ctime' => time()
                        ];

                        $res = Order_detail::insert($order_detail);

                    }

                    if( $res ){

                        $arr = array(
                            'status' => 1,
                            'msg' => '订单创建成功'
                        );
                        return $arr;

                    }

                }else{

                    $arr = array(
                        'status' => 2,
                        'msg' => '订单创建失败'
                    );
                    return $arr;

                }

            }

        }

    }


    //订单列表
    public function orderList( Request $request ){

        $user = $request -> session() -> get('user_info');

        $order_where = [
            'user_id' => $user['user_id'],
            'order_status' => 1
        ];

        $order_arr = Order::where($order_where) -> first();

        $detail_where = [
            'order_id' => $order_arr -> order_id,
            'order_no' => $order_arr -> order_no,
            'user_id' => $user['user_id'],
            'status' => 1
        ];

        $detail_arr = Order_detail::where($detail_where) -> get();

        return view('order.orderList') ->with(['order_arr' => $order_arr , 'detail_arr' => $detail_arr]);

    }


    //支付
    public function pay( Request $request ){

        $order_id = $request -> input();

        $user = $request -> session() -> get('user_info');

        $address_arr = Address::where(['user_id' => $user['user_id'] ,'status' => 1]) -> get() -> toArray();

        $address_default = array_column($address_arr,'address_default');

        if( empty( $address_arr ) ){

            $arr = array(
                'status' => 0,
                'msg' => '小仙女还没有收货地址哦~'
            );

            return $arr;

        }else{

                $arr = array(
                    'status' => 1,
                    'msg' => 'ok~'
                );

                return $arr;

        }

    }


    //潮购记录
    public function buyRecord( Request $request ){

        $user = $request -> session() -> get('user_info');

        $orderList = Order_detail::where(['user_id' => $user['user_id']]) -> get();

        return view('order.buyRecord') -> with('orderList' , $orderList);

    }


    public function show( Request $request ){
        $order_id = $request -> input("order_id");

        $type = $request->input('type');

//        print_r($type);

        $orderList = Order::where(['order_id' => $order_id]) -> first();
        $orderList=$orderList->order_no;
//        print_r($orderList);die;





        if($type=="wxpay"){
            return redirect("http://http://ppp.lixiaonitongxue.top/wtest?orderList=".$orderList);
        }else{
            return view('alipay.show') -> with('orderList' , $orderList);
        }

    }


    //异步
    public function notify(){

        $arr = $_POST;

        $configPath = app_path().'/extend/alipay/config.php';

        $config = require_once($configPath);

        $alipaySevice = new \AlipayTradeService($config);

        $alipaySevice -> writeLog(var_export($_POST,true));

//        $result = $alipaySevice -> check($arr);

        $result = true;

        if( $result ){

            if ($_POST['trade_status'] == 'TRADE_SUCCESS') {

                $where = [
                    'order_no' => $arr['out_trade_no'],
                    'order_amount' => $arr['buyer_pay_amount']
                ];

                $order_arr = Order::where($where) -> get();

                if( $order_arr ){

                    $order_data = [
                        'order_status' => 2,
                        'utime' => time()
                    ];

                    $detail_data = [
                        'status' => 2,
                        'utime' => time()
                    ];

                    $order_res = Order::where(['order_no' => $arr['out_trade_no']]) -> update($order_data);

                    $detail_res = Order_detail::where(['order_no' => $arr['out_trade_no']]) -> update($detail_data);

                }else{

                    echo 'fail';

                }

            }else{

                echo 'fail';

            }

        }else{

            echo 'fail';

        }

    }


    //同步
    public function sync(){

        echo 'ok~';

    }


    public function result( Request $request ){

        $arr = $request -> input();

        $orderNO = $arr['WIDout_trade_no'];

        $orderName = $arr['WIDsubject'];

        $orderDesc = $arr['WIDbody'];

        $orderMoney = $arr['WIDtotal_amount'];

        $timeout_express = '1m';


        $configPath = app_path().'/extend/alipay/config.php';

        $config = require_once($configPath);

        $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($orderDesc);
        $payRequestBuilder->setSubject($orderName);
        $payRequestBuilder->setOutTradeNo($orderNO);
        $payRequestBuilder->setTotalAmount($orderMoney);
        $payRequestBuilder->setTimeExpress($timeout_express);

        $payResponse = new \AlipayTradeService($config);
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        return ;


    }

}











