<?php

namespace App\Http\Controllers\Excel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Wechat_user as User;
use Excel;
class ExcelController extends Controller
{
    //导出
    public function export(){

        $user=User::All();
        $data=[];
        foreach($user as $v){
            $a=$v->toArray($v);
            $data[]=array_values($a);
            $key=array_keys($a);
        }
        $keys[]=$key;
        $data=array_merge($keys,$data);
        Excel::create('人物',function($excel) use($data){
            $excel->sheet('联系方式',function($sheet)use ($data){
                $sheet->rows($data);
            });
        })->export('xls');

    }

    //导入
    public function import(){
        $filePath='upload/'.iconv('UTF-8','GBK','aa').'.xls';
        $reader=Excel::load($filePath);
        $data=$reader->all();
        $sheet=[];
        $array=$data->toArray();
        $ac=$array[0];
        $bd=$array[1];
        dd($ac);

    }
}
