<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    //
    protected $table = 'shop_user';
    public $primaryKey = 'user_id';
    public $timestamps = false;

}
