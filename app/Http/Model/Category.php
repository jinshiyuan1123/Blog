<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table='blog_category';
    protected $primaryKey='cate_id';
    public $timestamps=false;
    protected $guarded=[];

    /**
     * @Desc:让分类显示有层次感
     * @static
     * @author:guomin
     * @date:2017-10-01 14:11
     * @return array
     */
     public function getTree(){
        $data=$this->orderBy('cate_order','asc')->get();
        $cate=[];
        foreach($data as $k=>$v){
            if($v->cate_pid==0){
                $data[$k]['_cate_name']=$data[$k]['cate_name'];
                $cate[]=$data[$k];
                foreach($data as $m=>$n){
                    if($n->cate_pid==$v->cate_id){
                        $data[$m]['_cate_name']=str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',2).$data[$m]['cate_name'];
                        $cate[]=$data[$m];
                    }
                }
            }

        }
        return $cate;
    }





}
