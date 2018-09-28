<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_article',function(Blueprint $table){
            $table->increments('article_id')->index();
            $table->integer('author_id')->index();
            $table->integer('article_pid');
            $table->timestamp('created_at');
            $table->string('article_title');
            $table->text('content');
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
