<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Navs::orderBy('nav_id','asc')->paginate(5);
        return view('admin.navs.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.navs.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=Input::except('_token');
        $rules=[
            'nav_name'=>'required',
            'nav_order'=>'required|integer',
            'nav_alias'=>'required',
            'nav_url'=>'required'
        ];
        $messages=[
            'nav_name.required'=>'导航名称不能为空',
            'nav_order.required'=>'导航排序不能为空',
            'nav_alias.required'=>'导航别名不能为空',
            'nav_order.integer'=>'导航排序必须为整数',
            'nav_url.required'=>'导航链接不能为空'

        ];
        $validator=Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re=Navs::create($input);
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
        }else{
            $errors=$validator->errors()->all();
            $error=implode(',',$errors);
            $data=[
                'status'=>0,
                'msg'=>$error
            ];
        }
        return $data;
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
        $data=Navs::find($id);
        return view('admin.navs.edit',compact('data'));
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
            'nav_name'=>'required',
            'nav_order'=>'required|integer',
            'nav_alias'=>'required',
            'nav_url'=>'required'
        ];
        $messages=[
            'nav_name.required'=>'导航名称不能为空',
            'nav_order.required'=>'导航排序不能为空',
            'nav_alias.required'=>'导航别名不能为空',
            'nav_order.integer'=>'导航排序必须为整数',
            'nav_url.required'=>'导航链接不能为空'

        ];
        $validator=Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re=Navs::where('nav_id',$id)->update($input);
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
        }else{
            $errors=$validator->errors()->all();
            $error=implode(',',$errors);
            $data=[
                'status'=>0,
                'msg'=>$error
            ];
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re=Navs::where('nav_id',$id)->delete();
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

    public function changeOrder($nav_id,$nav_order){
        $re=Navs::where('nav_id',$nav_id)->update(['nav_order'=>$nav_order]);
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
