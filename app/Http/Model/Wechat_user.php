<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Wechat_user extends Model
{
    //
    protected $table='blog_wechat_user';
    protected $primaryKey='user_id';
    public $timestamps=false;
    protected $guarded=[];
}
