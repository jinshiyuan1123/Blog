<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //文章分类表
        Schema::create('blog_category',function(Blueprint $table){
            $table->increments('cate_id');
            $table->string('cate_name',50);
            $table->string('cate_title');
            $table->string('cate_keywords');
            $table->string('cate_desc');
            $table->integer('cate_view');
            $table->integer('cate_order')->default(0);
            $table->integer('cate_pid')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
