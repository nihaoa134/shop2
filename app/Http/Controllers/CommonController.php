<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Libs\alisms\SignatureHelper;

class CommonController extends Controller
{

    protected function fail( $msg = '' , int $status = 1 , array $data = [] ){

        return response() -> json(
            [
                'status' => $status,
                'msg' => $msg,
                'data' => $data
            ]
        );
    }

    protected function success( $data = [] ,$msg = 'success' ,$status = 1000 ){

        return response() -> json(
            [
                'status' => $status,
                'msg' => $msg,
                'data' => $data
            ]
        );
    }



    /*  随机生成短信发送的验证码**/
    function createCode(){

        $str = '01234567890123456789123456789';

        $res = substr( str_shuffle( $str ) , rand( 0 , 15 ) , 6 );

        return $res;
    }

}
