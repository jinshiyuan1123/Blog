<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogConfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_conf',function(Blueprint $table){
            $table->increments('conf_id');
            $table->string('conf_title')->comment('配置标题');
            $table->string('conf_name')->comment('配置名称');
            $table->text('conf_content')->comment('配置内容');
            $table->integer('conf_order')->default(1)->comment('配置排序');
            $table->string('conf_tips',100)->comment('配置提示');
            $table->string('field_type')->comment('字段类型');
            $table->string('field_value')->comment('字段值');
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
