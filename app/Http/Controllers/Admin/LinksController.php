<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data=Links::orderBy('link_order','asc')->get();
        return view('admin.links.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.links.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       $input=Input::except('_token');
        $rules=[
            'link_name'=>'required',
            'link_title'=>'required',
            'link_url'=>'required',
            'link_order'=>'required|integer',
        ];
        $messages=[
            'link_name.required'=>'链接名称不能为空',
            'link_title.required'=>'链接标题不能为空',
            'link_url.required'=>'链接url不能为空',
            'link_order.required'=>'链接排序不能为空',
            'link_order.integer'=>'排序必须为整数'
        ];
        $validator=Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re=Links::create($input);
            if($re){
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
            $errors=collect($validator->errors()->all());
            $error=$errors->implode(',');
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
        $data=Links::find($id);
        return view('admin.links.edit',compact('data'));
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
        $input=Input::except('_token');
        $rules=[
            'link_name'=>'required',
            'link_title'=>'required',
            'link_url'=>'required',
            'link_order'=>'required|integer',
        ];
        $messages=[
            'link_name.required'=>'链接名称不能为空',
            'link_title.required'=>'链接标题不能为空',
            'link_url.required'=>'链接url不能为空',
            'link_order.required'=>'链接排序不能为空',
            'link_order.integer'=>'排序必须为整数'
        ];
        $validator=Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re=Links::where('link_id',$id)->update($input);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re=Links::where('link_id',$id)->delete();
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
        return $data;
    }

    public function changeOrder($link_id,$link_order){
        $re=Links::where('link_id',$link_id)->update(['link_order'=>$link_order]);
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
}
