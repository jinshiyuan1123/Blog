<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $table='blog_articles';
    protected $primaryKey='art_id';
    public $timestamps=false;
    protected $guarded=[];

    public function getCate(){
        $result=$this->leftJoin('blog_category','blog_articles.art_pid','=','blog_category.cate_id')
            ->select('blog_category.cate_name',
                'blog_articles.art_id',
                'blog_articles.art_pid',
                'blog_articles.art_author',
                'blog_articles.art_title',
                'blog_articles.art_time',
                'blog_articles.art_view',
                'blog_articles.is_show',
                'blog_articles.is_pass'
            )->paginate(5);
        return $result;
    }
}
