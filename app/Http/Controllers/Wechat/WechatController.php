<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Model\Goods;

class WechatController extends Controller
{
    public function wechatIndex()
    {
        $str = file_get_contents("php://input");

        $objxml = simplexml_load_string($str);

        file_put_contents('logs/wx.log',$str,FILE_APPEND);

/*        $ToUserName = $objxml->ToUserName;

        $FormUserName = $objxml->FromUserName;

        $MsgType = $objxml->MsgType;

        $Event = $objxml->Event;

        $Content = $objxml->Content;

        $CreateTime = $objxml->CreateTime;*/

        $openid = $objxml->FromUserName;

        $type = $objxml->EventKey;
        if($type == 1){
            $type = '这是1';
        }elseif($type == 2){
        $type = '这是2';
        }elseif($type == 3){
        $type = '这是3';
        }

        $redis = new \redis;
        $redis->connect("127.0.0.1",6379);//exit;
        $id = $redis->incr('id');
        $hest = "id_{$id}";
        $like = "listkey";
        $redis->hset($hest,"id","$id");
        $redis->hset($hest,"openid","$openid");
        $redis->hset($hest,"type","$type");
        $redis->rPush($like,$hest);

        /*if ($MsgType == 'text') {

            $goodsList = Goods::where('goods_name', 'like', "%$Content%") -> first();

            $time = time();

            $url = "http://funny.wanxiaoyu.cn";

            $xml = "
                <xml>
                <ToUserName><![CDATA[$FormUserName]]></ToUserName>
                <FromUserName><![CDATA[$ToUserName]]></FromUserName>
                <CreateTime>$time</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>1</ArticleCount>
                    <Articles>
                        <item>
                            <Title><![CDATA[{$goodsList -> goods_name}]]></Title>
                            <Description><![CDATA[{$goodsList -> goods_selfprice}]]></Description>
                            <PicUrl><![CDATA[{$goodsList -> goods_img}]]></PicUrl>
                            <Url><![CDATA[$url]]></Url>
                        </item>
                    </Articles>
            </xml>
            ";

            echo $xml;

        }*/

    }

}