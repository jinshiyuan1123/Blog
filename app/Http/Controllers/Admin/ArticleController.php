<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    /**
     * @Desc:首页显示
     * @author:guomin
     * @date:2017-10-07 15:24
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //$data=Article::orderBy('art_id','asc')->paginate(5);
        $article=new Article();
        $data=$article->getCate();
       return view('admin.article.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category=new Category();
        $cate=$category->getTree();
        return view('admin.article.add')->with('cate',$cate);
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
        $input=Input::except('_token','file');
        $input['art_time']=date('Y-m-d H:i:s');
        $rules=[
            'art_title'=>'required',
            'art_pid'=>'required',
            'art_author'=>'required',
            'art_thumb'=>'required',
            'art_tag'=>'required',
            'art_desc'=>'required',
            'art_content'=>'required',
        ];
        $messages=[
            'art_title.required'=>'文章标题不能为空',
            'art_pid.required'=>'分类分类不能为空',
            'art_author.required'=>'分类作者不能为空',
            'art_thumb.required'=>'请上传缩略图',
            'art_tag.required'=>'文章标签不能为空',
            'art_desc.required'=>'文章简介不能为空',
            'art_content.required'=>'内容不能为空',
        ];
        $validator=Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re=Article::create($input);
            if($re){
                $data=[
                    'status'=>1,
                    'msg'=>'文章新增成功'
                ];
            }else{
                $data=[
                    'status'=>0,
                    'msg'=>'文章新增失败'
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
        $category=new Category();
        $cate=$category->getTree();
        $data=Article::find($id);
        return view('admin.article.edit',compact('cate','data'));
    }

    /**
     * @Desc:更新
     * @author:guomin
     * @date:2017-10-07 15:24
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        //

        $input=Input::except('_token','file');
        $rules=[
            'art_title'=>'required',
            'art_pid'=>'required',
            'art_author'=>'required',
            'art_thumb'=>'required',
            'art_tag'=>'required',
            'art_desc'=>'required',
            'art_content'=>'required',
        ];
        $messages=[
            'art_title.required'=>'文章标题不能为空',
            'art_pid.required'=>'分类分类不能为空',
            'art_author.required'=>'分类作者不能为空',
            'art_thumb.required'=>'请上传缩略图',
            'art_tag.required'=>'文章标签不能为空',
            'art_desc.required'=>'文章简介不能为空',
            'art_content.required'=>'内容不能为空',
        ];
        $validator=Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re=Article::where('art_id',$id)->update($input);
            if($re){
                $data=[
                    'status'=>1,
                    'msg'=>'文章修改成功'
                ];
            }else{
                $data=[
                    'status'=>0,
                    'msg'=>'文章修改失败'
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
        //
        $re=Article::where('art_id',$id)->delete();
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
     * @Desc:文章审核
     * @author:guomin
     * @date:2017-10-02 18:28
     * @param $art_id
     * @return mixed
     */
    public function shenhe($art_id){
       // echo $art_id;
        return Article::where('art_id',$art_id)->update(['is_pass'=>1]);
    }

    /**
     * @Desc:文章上架
     * @author:guomin
     * @date:2017-10-02 18:27
     * @param $art_id
     * @return mixed
     */
    public function up($art_id){
        // echo $art_id;
        return Article::where('art_id',$art_id)->update(['is_show'=>1]);
    }

    /**
     * @Desc:文章下架
     * @author:guomin
     * @date:2017-10-02 18:27
     * @param $art_id
     * @return mixed
     */
    public function stop($art_id){
         //echo $art_id;
        return Article::where('art_id',$art_id)->update(['is_show'=>0,'is_pass'=>0]);
    }
}
