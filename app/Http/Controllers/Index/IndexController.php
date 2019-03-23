<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

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
        print_r($_GET);die;
        $appid = "wx0ed775ffa80afa46";
        $appsecret= "6a5574a26d9bc3db5a3df198f16d855d";
        $code = $request->input('code');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $token_json = file_get_contents($url);
        $token_arr = json_decode($token_json,true);
        //print_r($token_arr);die;
        $openid = $token_arr['openid'];
        print_r($openid);
    }

}
