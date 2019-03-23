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

}
