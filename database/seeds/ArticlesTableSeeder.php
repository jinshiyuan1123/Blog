<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=1;$i<30;$i++){
            DB::table('blog_articles')->insert([
                'art_pid'=>1,
                'art_title'=>'title',
                'art_author'=>'guomin',
                'art_tag'=>'体育',
                'art_desc'=>'dflflsfkld',
                'art_content'=>'sdflsfjklsfjlsdjfklsdjfklsjfkdsl'.str_random(10),
                'art_thumb'=>'upload/201710021506926060386.png'
            ]);
        }

    }
}
