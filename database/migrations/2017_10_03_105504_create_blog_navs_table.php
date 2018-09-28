<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogNavsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_navs',function(Blueprint $table){
            $table->increments('nav_id');
            $table->string('nav_name',100)->comment('导航名称');
            $table->string('nav_alias',100)->comment('别名');
            $table->string('nav_url')->comment('导航链接');
            $table->integer('nav_order')->default(1)->comment('导航排序');
            $table->timestamp('created_at');
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
