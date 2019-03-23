<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\CommonController;
use App\Model\User;
use App\Model\Users;
use Illuminate\Http\Request;

class AccountController extends CommonController
{

    //注册
    public function register(Request $request)
    {

        if ($request->isMethod('post')) {

            $tel = $request->post('tel');

            $pwd = $request->post('pwd');

            $conpwd = $request->post('conpwd');

            $user_tel = Users::where(['tel' => $tel])->first();

            if (!empty($user_tel)) {

                return $this->fail('该手机号已注册');

            } else {

                $userInfo = [
                    'tel' => $tel,
                    'pwd' => md5($pwd),
                    'ctime' => time()
                ];

                $request->session()->put('userInfo', $userInfo);

                return $this->success();

            }

        } else {

            return view('account.register');

        }

    }

    //发送验证码
    public function sendCode(Request $request)
    {

        $user_tel = $request->post('tel');

        $num = $this->createCode();

        $send = new \send();

        $tel = $user_tel;

        $res = $send->show($tel, $num);

        echo $res;

        if ($res = 100) {

            $Info = [
                'code' => $num,
                'time' => time()
            ];

            $request->session()->put('Info', $Info);

            return $this->success('发送成功');

        } else {

            return $this->fail('发送失败');

        }

    }

    //注册
    public function regauth(Request $request)
    {


        if ($request->isMethod('post')) {

            $tel = $request->post('tel');

            $code = $request->post('code');

            $sendCode = $request->session()->get('Info');

            $pwd = $request->session()->get('userInfo');

            if ($code != $sendCode['code']) {

                return $this->fail('验证码有误');

            } else {

                $info = [
                    'tel' => $tel,
                    'code' => $code,
                    'pwd' => $pwd['pwd'],
                    'ctime' => time()
                ];

                $res = Users::insert($info);

                if ($res) {

                    return $this->success('注册成功');

                } else {

                    return $this->fail('注册失败');

                }

            }

        } else {

            $userInfo = $request->session()->get('userInfo');

            return view('account.regauth', ['userInfo' => $userInfo['tel']]);

        }

    }

    //登录
    public function login(Request $request)
    {

        if ($request->isMethod('post')) {

            $tel = $request->input('tel');

            $user_pwd = $request->input('pwd');

            $pwd = md5($user_pwd);

            $arr = Users::where(['tel' => $tel])->first();

//        dd($arr);

            if ($pwd == $arr['pwd']) {

                $user_info = [
                    'user_id' => $arr['user_id'],
                    'tel' => $tel,
                    'pwd' => $pwd
                ];


                return $this->success('登录成功');

            } else {

                return $this->fail('登录失败');


            }

        }

        return view('account.login');


    }


    //用户中心
    public function userPage()
    {

        return view('account.userpage');

    }

    //获取code
    public function wxlogin()
    {
        $urlstart = urlencode("http://ppp.lixiaonitongxue.top/wxlogincode");
        $appid = "wx0ed775ffa80afa46";
        $scope = "snsapi_userinfo";
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$urlstart&response_type=code&scope=$scope&state=STATE#wechat_redirect";
        echo "<a href=" . $url . ">微信登陆</a>";
    }

    public function wxlogincode(Request $request)
    {
        //print_r($_GET);
        $appid = "wx0ed775ffa80afa46";
        $appsecret = "6a5574a26d9bc3db5a3df198f16d855d";
        $code = $request->input('code');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $token_json = file_get_contents($url);
        $token_arr = json_decode($token_json, true);
        //print_r($token_arr);
        //查询数据库中是否存在该账号
        $unionid = $token_arr['openid'];
        $user_info = $request->session()->get('user_info');//user_id
        $where = [
            'user_id' => $user_info['user_id'],
        ];
        $bol = Users:: where($where)->update(['openid' => $unionid]);
        var_dump($bol);
/*        $where = [
            'openid' => $unionid
        ];
        $wx_user_info = Users::where($where)->first();
        if ($wx_user_info) {
            $user_info = Users::where(['wechat_id' => $wx_user_info->id])->first();
        }

        if (empty($wx_user_info)) {
            return view('account.register');

        }*/

    }
    //获取code
    public function wxlogin1()
    {
        $urlstart = urlencode("http://ppp.lixiaonitongxue.top/weixinlogin");
        $appid = "wx0ed775ffa80afa46";
        $scope = "snsapi_userinfo";
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$urlstart&response_type=code&scope=$scope&state=STATE#wechat_redirect";
        echo "<a href=" . $url . ">微信登陆</a>";
    }
    public function weixinlogin(Request $request){
        $appid = "wx0ed775ffa80afa46";
        $appsecret = "6a5574a26d9bc3db5a3df198f16d855d";
        $code = $request->input('code');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $token_json = file_get_contents($url);
        $token_arr = json_decode($token_json, true);
        //print_r($token_arr);
        //查询数据库中是否存在该账号
        $openid = $token_arr['openid'];
                $where = [
            'openid' => $openid
        ];
        $wx_user_info = Users::where($where)->first();
        $info = json_decode($wx_user_info,true);
        print_r($info);die;
        $name = $info['tel'];
        $openid = $info['openid'];
        $time = time();
        print_r($name);
        print_r($openid);die;
        if (empty($wx_user_info)) {

            return view('account.register');

        }else{
            $redis = new \redis;
            $redis->connect("127.0.0.1",6379);//exit;
            $like="openid";

            $this->success('登录成功');
            return view('account.userpage');
        }
    }
}