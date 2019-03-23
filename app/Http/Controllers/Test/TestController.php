<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Model\Test;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class TestController extends Controller
{

    public function test(){


        $sql = "select * from  shop_goods";

        $arr = DB::select($sql);

//        dd($arr);
        var_dump($arr);
//        echo $id ;

//        return view( 'test.test' );

    }


    public function add(){

        $cate_list = User::select() -> get();

//        dd($cate_list);

        return view('test.add') -> with( ['cate_list' => $cate_list] );

    }

    public function addDo( Request $request ){

        $data = $request -> input();

        $res = Test::insertGetId($data);

        return $res;

    }

    public function goodsList(){

        $goods_list = Test::join('category as cate','goods.cate_id','=','cate.cate_id')
                        -> where( ['status' => 1] )
                        ->paginate( 3 );

        //print_r($goods_list);你

        return view('test.goodsList') -> with( ['goods_list' => $goods_list] );

    }

    public function delete( Request $request )
    {

        $id = $request->input('id');

        $arr = [
            'status' => 2
        ];

        $res = Test::where(['id' => $id])->update( $arr );

        if ($res) {

            return 1;

        } else {

            return 0;

        }

    }

    public function update( $id ){

        $cate_list = User::select() -> get();

        $goods_list = Test::where(['id' => $id]) -> select() -> get();

        return view('test.update') -> with( ['goods_list' => $goods_list , 'cate_list' => $cate_list] );

    }


    public function updateDo( Request $request ){

        $goods_data = $request->input();

        $res = Test::where(['id' => $goods_data['id']]) -> update($goods_data);

        if($res){
            return 1;
        }else{
            return 0;
        }

    }


    //即点即改
    public function ajaxUpd(Request $request){

        $arr = $request -> input();

        $bol = Test::where('id',$arr['id']) -> update(['name' => $arr['data']]);

        if($bol){

            return 1;

        }else{

            return 0;

        }

    }


    public function goodsSelect( Request $request ){

        $arr = $request -> input();

//        var_dump($arr);

        $is_hot = $arr['is_hot'];

        $is_sole = $arr['is_sole'];

        $where = [
            'is_hot' => $is_hot,
            'is_sole' => $is_sole,
            'status' => 1
        ];

        $goods_list = Test::join('category as cate','goods.cate_id','=','cate.cate_id')
            -> where( $where )
            ->paginate( 3 );

        return view('test.list') -> with( ['goods_list' => $goods_list] );

    }

}
