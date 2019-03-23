<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    //
    protected $table = 'shop_order_detail';
    public $primaryKey = 'id';
    public $timestamps = false;

}
