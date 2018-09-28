<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['middleware'=>['web'],'namespace'=>'Home'],function(){
    Route::get('/', 'IndexController@index');
    Route::get('/article/{art_id}', 'ArticleController@index');
    Route::get('/cate/{cate_id}', 'ArticleController@cate');

});
//Route::get('/export','Excel\ExcelController@export');

//Route::get('/import','Excel\ExcelController@import');

Route::resource('/check','Wechat\WechatController');
Route::resource('/job','Home\IndexController@job');
Route::get('/material','Wechat\WechatController@material');
Route::get('/sendMail','Admin\MailController@index');
Route::get('/sendText','Admin\MailController@sendText');
Route::get('/sendMailWithAttachment','Admin\MailController@sendMailWithAttachment');
Route::get('/sendMailWithPic','Admin\MailController@sendMailWithPic');
//Route::get('/tuling','Wechat\WechatController@getTulLing');
Route::resource('/MUI','MUI\MuiController');
Route::group(['middleware'=>['web'],'prefix'=>'admin','namespace'=>'Admin'],function(){
    //后台登录
    Route::any('/login','LoginController@login');

    //验证码路由
    Route::get('/code','LoginController@code');
});

//获取用户信息
Route::get('/getuser','Wechat\WechatController@getUserInfo');
Route::group(['middleware'=>['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function(){
    //后台首页
    Route::get('/index','IndexController@index');
    //退出登录
    Route::get('/quit','LoginController@quit');
    //修改密码
    Route::any('/pass','IndexController@pass');
    //测试方法
    Route::any('/test','IndexController@test');
    //文章分类
    Route::resource('/category','CategoryController');
    //文章管理
    Route::resource('/article','ArticleController');
    Route::resource('/excelsheet','ExcelSheetController');
    //修改分类排序
    Route::get('/changeOrder/{cate_id}/cate_order/{cate_order}','CategoryController@changeOrder');
    //上传图片
    Route::any('/upload','CommonController@upload');
    //导入excel
    Route::any('/import','ExcelSheetController@import');
    //文章审核
    Route::get('/shenhe/{art_id}','ArticleController@shenhe');
    //文章上架
    Route::get('/up/{art_id}','ArticleController@up');
    //文章下架
    Route::get('/stop/{art_id}','ArticleController@stop');
    //友情链接
    Route::resource('/links','LinksController');
    //修改友情链接排序
    Route::get('/changeLinkOrder/{link_id}/link_order/{link_order}','LinksController@changeOrder');
    //导航
    Route::resource('/navs','NavsController');
    //修改导航排序
    Route::get('/changeNavOrder/{nav_id}/nav_order/{nav_order}','NavsController@changeOrder');
    //网站配置
    Route::resource('/conf','ConfigController');
    //修改配置顺序
    Route::get('/changeConfOrder/{conf_id}/conf_order/{conf_order}','ConfigController@changeOrder');
    Route::post('/multi_edit','ConfigController@multiEdit');
    Route::get('/gen_conf','ConfigController@putFile');
});