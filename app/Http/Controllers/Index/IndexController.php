<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Model\Users;

class IndexController extends Controller
{

    public function index(){

        $goods_arr = Goods::where( ['status' => 5] )
            -> orderBy( 'goods_id' , 'desc' )
            -> get();

        return view( 'index.index' ) -> with( ['goods_arr' => $goods_arr] );

    }


    public function productList()
    {

        $goods_data = Goods::where( 'status' , 4 ) -> paginate(4);

        $view = view( 'index.productList' ) -> with('product', $goods_data);

        $data['view_content'] = response($view) -> getContent();

        $data['page_count'] = $goods_data->lastPage();

        return $data;


    }
    //微信登陆
    public function wxlogin(){
        $urlstart = urlencode("http://ppp.lixiaonitongxue.top/wxlogincode");
        $appid = "wx0ed775ffa80afa46";
        $scope = "snsapi_userinfo";
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$urlstart&response_type=code&scope=$scope&state=STATE#wechat_redirect";
        echo "<a href=".$url.">微信登陆</a>";
    }
    public function  wxlogincode(Request $request){
//        print_r($_GET);die;
        $appid = "wx0ed775ffa80afa46";
        $appsecret= "6a5574a26d9bc3db5a3df198f16d855d";
        $code = $request->input('code');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $token_json = file_get_contents($url);
        $token_arr = json_decode($token_json,true);
        print_r($token_arr);die;
//        $openid = $token_arr['openid'];
//        print_r($openid);
        //查询数据库中是否存在该账号
        $unionid = $token_arr['unionid'];
        $where = [
            'union_id'   =>  $unionid
        ];
        $wx_user_info = Users::where($where)->first();
        print_r($wx_user_info);die;
        if($wx_user_info){
            $user_info = Users::where(['wechat_id'=>$wx_user_info->id])->first();
        }

        if(empty($wx_user_info)){
            //绑定微信
            $data = [
                'openid'        =>  $token_arr['openid'],

            ];
            $wechat_id = Users::insertGetId($data);
            $rs = Users::insertGetId(['wechat_id'=>$wechat_id]);
            if($rs){

                echo '绑定成功';
                header("refresh:2,url='/user/center'");
            }else{
                echo '注册失败';
            }
            exit;
        }
    }

}
