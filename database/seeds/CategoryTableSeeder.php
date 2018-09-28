<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Category;
class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('blog_category')->delete();
        Category::create([
            'cate_name'=>'php',
            'cate_title'=>'php教程',
            'cate_keywords'=>'最好的语言',
            'cate_desc'=>'llalalll',
            'cate_view'=>0,
        ]);
    }
}
