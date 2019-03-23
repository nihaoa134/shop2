<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //
    protected $table = 'shop_goods';
    public $primaryKey = 'goods_id';
    public $timestamps = false;

}
