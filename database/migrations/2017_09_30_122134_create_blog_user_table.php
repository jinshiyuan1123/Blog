<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_user',function(Blueprint $table){
            $table->increments('user_id')->index();
            $table->string('user_name');
            $table->string('user_pass');
            $table->integer('login_count');
            $table->timestamp('last_login');
            $table->string('last_ip');
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
