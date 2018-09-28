<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table='blog_conf';
    protected $primaryKey='conf_id';
    protected $guarded=[];
    public $timestamps=false;
}
