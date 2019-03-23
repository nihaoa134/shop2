<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $table = 'shop_cart';
    public $primaryKey = 'cart_id';
    public $timestamps = false;

}
