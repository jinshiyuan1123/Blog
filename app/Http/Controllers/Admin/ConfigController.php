<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Config::orderBy('conf_order','asc')->get();
        foreach($data as $key=>&$value){
            switch($value->field_type){
                case 1:
                   $value->conf_content='<div class="formControls col-xs-8 col-sm-12">
                                    <input type="text"  value="'.$value->conf_content.'" class="input-text" name="conf_content['.$value->conf_id.'][1]">
                                </div>';
                    break;
                case 2:
                    $value->conf_content='<div class="formControls col-xs-8 col-sm-12">
                                    <textarea class="textarea" name="conf_content['.$value->conf_id.'][2]">'.$value->conf_content.'</textarea>
                                </div>';
                    break;
                case 3:
                    if($value->field_value==1){
                        $value->conf_content='<div class="formControls col-xs-8 col-sm-9 skin-minimal">
                                    <div class="radio-box">
                                        <input name="conf_content['.$value->conf_id.'][3]" value="1" type="radio" id="field_value-1" checked>
                                        <label for="field_value-1">开启</label>
                                    </div>
                                    <div class="radio-box">
                                        <input type="radio" value="0" id="field_value-2" name="conf_content['.$value->conf_id.'][3]">
                                        <label for="field_value-2">关闭</label>
                                    </div>
                                </div>';
                    }elseif($value->field_value==0){
                        $value->conf_content='<div class="formControls col-xs-8 col-sm-9 skin-minimal">
                                    <div class="radio-box">
                                        <input name="conf_content['.$value->conf_id.'][3]" value="1" type="radio" id="" >
                                        <label for="field_value-1">开启</label>
                                    </div>
                                    <div class="radio-box">
                                        <input type="radio" value="0" id="" name="conf_content['.$value->conf_id.'][3]" checked>
                                        <label for="field_value-2">关闭</label>
                                    </div>
                                </div>';
                    }
                    break;
            }
        }
//        print_r($data);
//        die();
        return view('admin.conf.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.conf.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->input('field_type')==1||$request->input('field_type')==2){
            $input=Input::except('_token','field_value');
        }else{
            $input=Input::except('_token','conf_content');
        }
        $rules=[
            'conf_name'=>'required',
            'conf_title'=>'required',
            'conf_order'=>'required|integer',
        ];
        $messages=[
            'conf_name.required'=>'名称不能为空',
            'conf_title.required'=>'标题不能为空',
            'conf_order.required'=>'排序不能为空',
            'conf_order.integer'=>'排序必须为整数'
        ];
        $validator=Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re=Config::create($input);
            if(1){
                $data=[
                    'status'=>1,
                    'msg'=>'新增成功'
                ];
            }else{
                $data=[
                    'status'=>0,
                    'msg'=>'新增失败'
                ];
            }
            return $data;
        }else{
            $errors=$validator->errors()->all();
            $error=implode(',',$errors);
            $data=[
                'status'=>0,
                'msg'=>$error
            ];
            return $data;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re=Config::where('conf_id',$id)->delete();
        if($re){
            $data=[
                'status'=>1,
                'msg'=>'删除成功'
            ];
        }else{
            $data=[
                'status'=>0,
                'msg'=>'删除失败'
            ];
        }
        $this->putFile();
        return $data;
    }

    public function changeOrder($conf_id,$order_id){
        $re=Config::where('conf_id',$conf_id)->update(['conf_order'=>$order_id]);
        if($re){
            $data=[
                'status'=>1,
                'msg'=>'修改成功'
            ];
        }else{
            $data=[
                'status'=>0,
                'msg'=>'修改失败'
            ];
        }
        return $data;
    }

    public function multiEdit(Request $request){
        $input=$request->input('conf_content');
        foreach($input as $key=>$value){
            foreach($value as $m=>$n){
                $new_input[]=[
                    'conf_id'=>$key,
                    'field_type'=>$m,
                    'conf_content'=>$n
                ];
            }
        }
        foreach($new_input as $k=>$v){
            if($v['field_type']==3){
                $re[$k]=Config::where('conf_id',$v['conf_id'])->update(['field_value'=>$v['conf_content']]);
            }else{
                $re[$k]=Config::where('conf_id',$v['conf_id'])->update(['conf_content'=>$v['conf_content']]);
            }
        }
        $msg='';
        foreach($re as $k=>$v){
            switch($v){
                case 1:
                    $msg.='第'.($k+1).'条更新成功';
                    break;
                case 0:
                    $msg.='第'.($k+1).'条更新失败';
                    break;
            }
        }
        $this->putFile();
        return $msg;
    }

    private function putFile(){
        $config=Config::pluck('conf_content','conf_title')->all();
        $path=base_path().'\config\web.php';
        $str="<?php\n return \n".var_export($config,true)." ;\n?>";
        file_put_contents($path,$str);
    }




}
