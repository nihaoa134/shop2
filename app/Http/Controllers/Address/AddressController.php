<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\CommonController;
use App\Model\Address;
use App\Model\User;
use App\Model\Users;
use Illuminate\Http\Request;

class AddressController extends CommonController
{

    //新增地址页面
    public function writeAddress( Request $request ){

        return view('address.writeAddress');

    }

    //添加地址
    public function addressAdd( Request $request ){

        $user = $request -> session() -> get('user_info');

        $arr = $request -> input();

        if( array_key_exists('address_default' , $arr) ){

            $address_arr = [
                'address_man' => $arr['address_man'],
                'address_tel' => $arr['address_tel'],
                'area' => $arr['area'],
                'address_detail' => $arr['address_detail'],
                'address_default' => 1,
                'user_id' => $user['user_id'],
                'status' => 1,
                'ctime' => time()
            ];

            $address_res = Address::insert($address_arr);

            if( $address_res ){

                $arr = array(
                    'status' => 1,
                    'msg' => '地址添加成功,已设为默认'
                );

                return $arr;

            }

        }else{

            $address_arr = [
                'address_man' => $arr['address_man'],
                'address_tel' => $arr['address_tel'],
                'area' => $arr['area'],
                'address_detail' => $arr['address_detail'],
                'address_default' => 2,
                'user_id' => $user['user_id'],
                'status' => 1,
                'ctime' => time()
            ];

            $address_res = Address::insert($address_arr);

            if( $address_res ){

                $arr = array(
                    'status' => 2,
                    'msg' => '地址添加成功'
                );

                return $arr;

            }

        }

    }


    //地址列表
    public function address( Request $request ){

        $user = $request -> session() -> get('user_info');

        $addressList = Address::where(['user_id' => $user['user_id'] ,'status' => 1]) -> get();

        return view('address.address') -> with('addressList' , $addressList);

    }


    //默认地址修改
    public function addressUp( Request $request ){

        $address_id = $request -> input();

        $user = $request -> session() -> get('user_info');

        $where = [
            'user_id' => $user['user_id'],
            'address_default' => 1,
            'status' => 1
        ];

        $arr1 = [
            'address_default' => 2,
            'utime' => time()
        ];

        $res = Address::where($where) -> update($arr1);

//        if($res){

            $arr = [
                'address_default' => 1,
                'utime' => time()
            ];

            $address_res = Address::where(['address_id' => $address_id]) -> update($arr);

//        }

    }


    //删除
    public function addressDelete( Request $request ){

        $address_id = $request -> input();

        $arr = [
            'status' => 2,
            'utime' => time()
        ];

        $address_res = Address::where(['address_id' => $address_id]) -> update($arr);

//        dd($address_res);

    }


    //修改
    public function addressUpdate( Request $request ){

        $address_id = $request -> input();

        $where = [
            'address_id' => $address_id,
            'status' => 1
        ];

        $addressList = Address::where($where) -> get();

        return view('address.addressUpdate') -> with('addressList' , $addressList);

    }


    //执行修改
    public function updateDo( Request $request ){

        $arr = $request -> input();

        $where = [
            'address_id' => $arr['address_id'],
        ];

        $address_arr = [
            'address_man' => $arr['address_man'],
            'address_tel' => $arr['address_tel'],
            'area' => $arr['area'],
            'address_detail' => $arr['address_detail'],
            'utime' => time()
        ];

        $res = Address::where( $where ) -> update($address_arr);

        if( $res ){

            $arr = array(
                'status' => 1,
                'msg' => '地址修改成功'
            );

            return $arr;

        }else{

            $arr = array(
                'status' => 0,
                'msg' => '地址修改失败'
            );

            return $arr;

        }

    }

}
