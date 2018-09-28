<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    /**
     * @Desc:分类列表显示
     * @author:guomin
     * @date:2017-10-01 16:16
     * @return $this
     */
    public function index()
    {
        //
        $category=new Category();
        $data=$category->getTree();
        return view('admin.category.index')->with('data',$data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.category.add');
    }

    /**
     * @Desc:添加新分类
     * @author:guomin
     * @date:2017-10-07 15:14
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        //
        $input=Input::except('_token');
        $rules=[
            'cate_name'=>'required|between:2,16',
            'cate_order'=>'required|integer',
            'cate_title'=>'required'
        ];
        $messages=[
            'cate_name.required'=>'分类名称不能为空',
            'cate_name.between'=>'分类名称在2到16位之间',
            'cate_order.required'=>'排序不能为空',
            'cate_order.integer'=>'排序必须为整数',
            'cate_title.required'=>'分类标题不能为空',
        ];
        $validator=Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re=Category::create($input);
            if($re){
                $data=[
                    'status'=>1,
                    'msg'=>'分类新增成功'
                ];
            }else{
                $data=[
                    'status'=>0,
                    'msg'=>'分类新增失败'
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
        $data=Category::find($id);
        return view('admin.category.edit',compact('data'));
    }

    /**
     * @Desc:修改
     * @author:guomin
     * @date:2017-10-07 15:14
     * @param Request $request
     * @param $id 分类id
     * @return array
     */
    public function update(Request $request, $id)
    {
        //
        $input=Input::except('_token');
        $rules=[
            'cate_name'=>'required|between:2,16',
            'cate_order'=>'required|integer',
            'cate_title'=>'required'
        ];
        $messages=[
            'cate_name.required'=>'分类名称不能为空',
            'cate_name.between'=>'分类名称在2到16位之间',
            'cate_order.required'=>'排序不能为空',
            'cate_order.integer'=>'排序必须为整数',
            'cate_title.required'=>'分类标题不能为空',
        ];
        $validator=Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re=Category::where('cate_id',$id)->update($input);
            if($re){
                $data=[
                    'status'=>1,
                    'msg'=>'分类修改成功'
                ];
            }else{
                $data=[
                    'status'=>0,
                    'msg'=>'分类修改失败'
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
     * @Desc:删除分类
     * @author:guomin
     * @date:2017-10-07 15:15
     * @param $cate_id
     * @return array
     */
    public function destroy($cate_id)
    {
        //
        $re=Category::where('cate_id',$cate_id)->delete();
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

    /**
     * @Desc:分类排序
     * @author:guomin
     * @date:2017-10-07 15:15
     * @param $cate_id
     * @param $cate_order
     * @return array
     */
    public function changeOrder($cate_id,$cate_order){
        $category=Category::find($cate_id);
        $category->cate_order=$cate_order;
        $res=$category->save();
        if($res){
            $data=[
                'status'=>1,
                'msg'=>'修改成功',
            ];
        }else{
            $data=[
                'status'=>0,
                'msg'=>'修改失败',
            ];
        }
        return $data;
    }
}
