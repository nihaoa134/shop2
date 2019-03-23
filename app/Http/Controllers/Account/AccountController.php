<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\CommonController;
use App\Model\User;
use App\Model\Users;
use Illuminate\Http\Request;

class AccountController extends CommonController
{

    //注册
    public function register( Request $request ){

        if( $request -> isMethod('post') ){

            $tel = $request -> post( 'tel' );

            $pwd = $request -> post( 'pwd' );

            $conpwd = $request -> post( 'conpwd' );

            $user_tel = Users::where( ['tel' => $tel] ) -> first();

            if( !empty( $user_tel ) ){

                return $this -> fail( '该手机号已注册' );

            }else{

                $userInfo = [
                    'tel' => $tel,
                    'pwd' => md5($pwd),
                    'ctime' => time()
                ];

                $request -> session() -> put( 'userInfo' , $userInfo );

                return $this -> success();

            }

        }else{

            return view( 'account.register' );

        }

    }

    //发送验证码
    public function sendCode( Request $request ){

        $user_tel = $request -> post( 'tel' );

        $num = $this -> createCode();

        $send = new \send();

        $tel = $user_tel;

        $res = $send -> show( $tel , $num );

        echo $res;

        if( $res = 100 ){

            $Info = [
                'code' => $num,
                'time' => time()
            ];

            $request -> session() -> put( 'Info' , $Info );

            return $this -> success('发送成功');

        }else{

            return $this -> fail('发送失败');

        }

    }

    //注册
    public function regauth( Request $request ){


        if($request -> isMethod('post')){

            $tel = $request -> post('tel');

            $code = $request -> post('code');

            $sendCode = $request -> session() -> get('Info');

            $pwd = $request -> session() -> get('userInfo');

            if($code != $sendCode['code']){

                return $this -> fail('验证码有误');

            }else{

                $info = [
                    'tel' => $tel,
                    'code' => $code,
                    'pwd' => $pwd['pwd'],
                    'ctime' => time()
                ];

                $res = Users::insert($info);

                if( $res ){

                    return $this->success( '注册成功' );

                }else{

                    return $this->fail( '注册失败' );

                }

            }

        }else{

            $userInfo = $request -> session() ->get('userInfo');

            return view('account.regauth' , ['userInfo' => $userInfo['tel']]);

        }

    }

    //登录
    public function login( Request $request ){

        if($request -> isMethod('post')) {

            $tel = $request->input('tel');

            $user_pwd = $request->input('pwd');

            $pwd = md5( $user_pwd );

            $arr = Users::where(['tel' => $tel])->first();

//        dd($arr);

            if ($pwd == $arr['pwd']) {

                $user_info = [
                    'user_id' => $arr['user_id'],
                    'tel' => $tel,
                    'pwd' => $pwd
                ];

                $request -> session() -> put( 'user_info' , $user_info );

                return $this->success( '登录成功' );

            } else {

                return $this->fail( '登录失败' );


            }

        }

        return view( 'account.login' );




    }


    //用户中心
    public function userPage(){

        return view('account.userpage');

    }

}
