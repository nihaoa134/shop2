<?php
namespace App\Http\Controllers\Weixin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class PayController extends Controller
{
    public function wtest(Request $request){
        $order=$request->input('orderList');
        //print_r($order);
        $str = md5(time());
        $orderid = date('YmdHis',rand(1000000,300000000));
        $orderid = $orderid.rand(10000,30000);
        $key = '7c4a8d09ca3762af61e59520943AB26Q';
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $ip = $_SERVER['REMOTE_ADDR'];
        $notify_url = "http://ppp.lixiaonitongxue.top/wxstatus";
        $info = array(
            'appid' =>'wxd5af665b240b75d4',
            'mch_id' =>'1500086022',
            'nonce_str' =>$str,
            'sign_type' =>'MD5',
            'body' =>'席宏刚三条腿',
            'out_trade_no' =>$order,                       //本地订单号
            'total_fee' =>1,                               //用户要支付的总金额
            'spbill_create_ip' =>$ip,
            'notify_url' =>$notify_url,
            'trade_type' =>'NATIVE',
        );
//        print_r($info);die;
        ksort($info);
        $strpay = urldecode(http_build_query($info));
        $strpay.="&key=$key";
        $endstr = md5($strpay);
        $info['sign'] = $endstr;

        $obj =new \url;
        $arr2 = $obj->arr2Xml($info);
//        echo $arr2;
        $bol=$obj->sendPost($url,$arr2);
        //dump($bol);die;
        $data = simplexml_load_string($bol);
        $code = $data->code_url;
        //echo $code;die;
//        print_r($code);die;
        return view('weixin.wxpay',['code'=>$code]);

    }
    public function wxstatus(Request $request){
        $xml = file_get_contents("php://input");
        $arr = json_decode(json_encode(simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA)),true);
//        file_put_contents("logs/wxstatus.log",var_export($arr,true),FILE_APPEND);
        $sign = $arr['sign'];
//        $sign = "$sign\n";
        unset($arr['sign']);
        $newstr = $this->checksign($arr);
        $newstr = strtoupper($newstr);
//        $newstr="$newstr\n";
        file_put_contents("logs/sign.log",$sign,FILE_APPEND);
        file_put_contents("logs/sign.log",$newstr,FILE_APPEND);
        if($sign==$newstr){
            file_put_contents("/logs/wxstatus.log",$arr['out_trade_no'],FILE_APPEND);
            DB::table('shop_order')->where('order_no',$arr['out_trade_no'])->update(['order_paytype'=>2],['order_status'=>2]);
        }
    }
    private function checksign($arr){
        ksort($arr);
        $key = '7c4a8d09ca3762af61e59520943AB26Q';
        $strpay = urldecode(http_build_query($arr));
        $strpay.="&key=$key";
        $endstr = md5($strpay);
        return $endstr;
    }

}