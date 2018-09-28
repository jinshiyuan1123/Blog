<?php

use Illuminate\Database\Seeder;

class NavsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            [
                'nav_name'=>'python',
                'nav_alias'=>'全球最大的中文搜索引擎',
                'nav_url'=>'https://www.baidu.com',
                'nav_order'=>1
            ],
            [
                'nav_name'=>'java',
                'nav_alias'=>'全球最大的中文搜索引擎',
                'nav_url'=>'https://www.baidu.com',
                'nav_order'=>2
            ],
            [
                'nav_name'=>'go',
                'nav_alias'=>'全球最大的中文搜索引擎',
                'nav_url'=>'https://www.baidu.com',
                'nav_order'=>3
            ],
            [
                'nav_name'=>'c++',
                'nav_alias'=>'全球最大的中文搜索引擎',
                'nav_url'=>'https://www.baidu.com',
                'nav_order'=>4
            ],
            [
                'nav_name'=>'c#',
                'nav_alias'=>'全球最大的中文搜索引擎',
                'nav_url'=>'https://www.baidu.com',
                'nav_order'=>5
            ],
            [
                'nav_name'=>'VB',
                'nav_alias'=>'全球最大的中文搜索引擎',
                'nav_url'=>'https://www.baidu.com',
                'nav_order'=>6
            ],
            [
                'nav_name'=>'js',
                'nav_alias'=>'全球最大的中文搜索引擎',
                'nav_url'=>'https://www.baidu.com',
                'nav_order'=>7
            ],
        ];
        DB::table('blog_navs')->insert($data);
    }
}
