<?php

namespace App\Http\Controllers\Home;



use App\Http\Model\Article;
use App\Http\Model\Category;

class ArticleController extends CommonController
{

    public function index($id){

        $content=Article::find($id);
        $art_pid=$content->art_pid;
        $catename=Category::where('cate_id',$art_pid)->value('cate_name');
        Article::where('art_id',$id)->update(['art_view'=>$content->art_view+1]);
        return view('home.article',compact('content','catename'));
    }

    public function cate($id){
        $catename=Category::where('cate_id',$id)->value('cate_name');
       $article=Article::where(['art_pid'=>$id,'is_pass'=>1])->paginate(5);
       return view('home.cate',compact('article','catename'));
    }
}
