<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('links',function(Blueprint $table){
            $table->engine='MyISAM';
            $table->increments('link_id')->comment('主键');
            $table->string('link_name',50)->comment('名称');
            $table->string('link_title',50)->comment('标题');
            $table->string('link_url')->comment('链接');
            $table->integer('link_order')->comment('排序');
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
