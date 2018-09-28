@extends('layouts.admin')

@section('content')
<section class="Hui-article-box">
    <nav class="breadcrumb">
        <i class="Hui-iconfont"></i> <a href="{{url('admin/index')}}" class="maincolor">首页</a>
        <span class="c-999 en">&gt;</span>
        <span class="c-666">我的桌面</span>
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="Hui-article">
        <article class="cl pd-20">
            <p class="f-20 text-success">欢迎进入blog
                后台管理系统</p>
            <p>登录次数：{{$Info->login_count}} </p>
            <p>上次登录IP：{{$Info->last_ip}} 上次登录时间：{{$Info->last_login}}</p>
            <table class="table table-border table-bordered table-bg">
                <thead>
                <tr>
                    <th colspan="7" scope="col">信息统计</th>
                </tr>
                <tr class="text-c">
                    <th>统计</th>
                    <th>资讯库</th>
                    <th>图片库</th>
                    <th>产品库</th>
                    <th>用户</th>
                    <th>管理员</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-c">
                    <td>总数</td>
                    <td>92</td>
                    <td>9</td>
                    <td>0</td>
                    <td>8</td>
                    <td>20</td>
                </tr>
                <tr class="text-c">
                    <td>今日</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr class="text-c">
                    <td>昨日</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr class="text-c">
                    <td>本周</td>
                    <td>2</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr class="text-c">
                    <td>本月</td>
                    <td>2</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                </tbody>
            </table>
            <table class="table table-border table-bordered table-bg mt-20">
                <thead>
                <tr>
                    <th colspan="2" scope="col">服务器信息</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th width="30%">服务器计算机名</th>
                    <td><span id="lbServerName">http://127.0.0.1/</span></td>
                </tr>
                <tr>
                    <td>服务器IP地址</td>
                    <td>{{$_SERVER['SERVER_ADDR']}}</td>
                </tr>
                <tr>
                    <td>服务器域名</td>
                    <td>{{$_SERVER['SERVER_NAME']}}</td>
                </tr>
                <tr>
                    <td>服务器端口 </td>
                    <td>{{$_SERVER['SERVER_PORT']}}</td>
                </tr>

                    <tr>
                        <td>服务器版本 </td>
                        <td>{{$_SERVER['SERVER_SOFTWARE']}}</td>
                    </tr>

                <tr>
                    <td>本文件所在文件夹 </td>
                    <td>D:\WebSite\HanXiPuTai.com\XinYiCMS.Web\</td>
                </tr>
                <tr>
                    <td>服务器操作系统 </td>
                    <td>{{ PHP_OS }}</td>
                </tr>
                {{--linux下不存在此变量，服务器报错--}}
                @if(PATH_SEPARATOR==';')
                <tr>
                    <td>系统所在文件夹 </td>
                    <td>{{$_SERVER['SystemRoot']}}</td>
                </tr>
                @endif
                <tr>
                    <td>服务器脚本超时时间 </td>
                    <td>{{get_cfg_var('max_execution_time')}}秒</td>
                </tr>
                <tr>
                    <td>服务器的语言种类 </td>
                    <td>Chinese (People's Republic of China)</td>
                </tr>
                <tr>
                    <td>Zend 版本 </td>
                    <td>{{zend_version()}}</td>
                </tr>
                <tr>
                    <td>服务器当前时间 </td>
                    <td>{{date('Y-m-d H:i')}}</td>
                </tr>
                </tbody>
            </table>
        </article>
    </div>
</section>
@endsection

<!--请在下方写此页面业务相关的脚本-->
@section('javascriptfooter')
    <script>
        $('aaaa');
    </script>
 @endsection