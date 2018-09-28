<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('blog_articles',function(Blueprint $table){
            $table->increments('art_id')->index();
            $table->integer('art_pid');
            $table->string('art_author',100);
            $table->string('art_title',100);
            $table->string('art_tag',50);
            $table->string('art_desc');
            $table->string('art_thumb');
            $table->text('art_content');
            $table->dateTime('art_time');
            $table->integer('art_view')->default(0);
            $table->integer('is_show')->default(0);
            $table->integer('is_pass')->default(0);
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
