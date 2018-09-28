@extends('layouts.admin')

@section('content')
    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> <a href="{{url('admin/index')}}">首页</a> <span class="c-gray en">&gt;</span> 导航管理 <span class="c-gray en">&gt;</span> 导航列表 <a class="btn btn-success radius r btn-refresh" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="Hui-article">
            <article class="cl pd-20">
                <div class="cl pd-5 bg-1 bk-gray">
                    <span class="l">
                        <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
                        <a class="btn btn-primary radius" href="javascript:;" onclick="admin_navs_add('添加导航','{{url("admin/navs/create")}}',800,400)"><i class="Hui-iconfont">&#xe600;</i> 添加导航</a>
                    </span>
                    <span class="r">共有数据：<strong>{{$data->total()}}</strong> 条</span>
                </div>
                {{csrf_field()}}
                <div class="mt-10">
                    <table class="table table-border table-bordered table-hover table-bg">
                        <thead>
                        <tr>
                            <th scope="col" colspan="7">导航列表</th>
                        </tr>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" value="" name=""></th>
                            <th width="40">ID</th>
                            <th width="200">名称</th>
                            <th width="40">排序</th>
                            <th width="300">别名</th>
                            <th>链接</th>
                            <th width="70">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $v)
                            <tr class="text-c">
                                <td><input type="checkbox" value="{{$v->nav_id}}" name=""></td>
                                <td>{{$v->nav_id}}</td>
                                <td style="text-align: left;">{{$v->nav_name}}</td>
                                <td><input type="text" value="{{$v->nav_order}}" name="" style="width:50%;border-radius: 1px;text-align: center" onchange="changeOrder({{$v->nav_id}},this);"></td>
                                <td>{{$v->nav_alias}}</td>
                                <td>{{$v->nav_url}}</td>
                                <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_navs_edit('导航编辑','{{url("admin/navs/".$v->nav_id."/edit")}}',800,400)" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_navs_del(this,{{$v->nav_id}})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{$data->links()}}
            </article>
        </div>
    </section>
    <style>
        .pagination{
            padding-top: 10px;
            text-align: right;
        }
        .pagination li{
            display: inline-block;
        }
        .pagination li a{
            border: 1px solid #ccc;
            cursor: pointer;
            display: inline-block;
            margin-left: 2px;
            text-align: center;
            text-decoration: none;
            color: #666;
            height: 26px;
            line-height: 26px;
            text-decoration: none;
            margin: 0 0 6px 6px;
            padding: 0 10px;
            font-size: 14px;
        }
        .pagination li span{
            border: 1px solid #ccc;
            cursor: pointer;
            display: inline-block;
            margin-left: 2px;
            text-align: center;
            text-decoration: none;
            height: 26px;
            line-height: 26px;
            text-decoration: none;
            margin: 0 0 6px 6px;
            padding: 0 10px;
            font-size: 14px;
            background: #5a98de;
            color: #fff;
        }
    </style>
@endsection


@section('javascriptfooter')
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/laypage/1.2/laypage.js')}}"></script>
    <script type="text/javascript">
        $('.pagination li').each(function(){
            if($(this).hasClass('disabled')){
                $(this).children('span').css({
                    'background': '#fff',
                    'color': '#666',
                    'cursor':'default'
                });
            }
        });
        function changeOrder(nav_id,obj){
            $.ajax({
                url:"{{url('admin/changeNavOrder').'/'}}"+nav_id+'/nav_order/'+obj.value,
                type:'get',
                success:function(data){
                    if(data.status==1){
                        layer.msg(data.msg,{icon:6});
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }
                }
            });
        }
        /*分类-添加*/
        function admin_navs_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*分类-编辑*/
        function admin_navs_edit(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*管理员-角色-删除*/
        function admin_navs_del(obj,id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });
            layer.confirm(
                '导航删除须谨慎，确认要删除吗？',
                function(index){
                    $.ajax({
                        type:'delete',
                        url:"{{url('admin/navs')}}"+"/"+id,
                        success:function(data){
                            if(data.status==1){
                                $(obj).parents("tr").remove();
                                $('.bk-gray .r strong').text(function(index,value){
                                    return value-1;
                                });
                                layer.msg(data.msg,{icon:1,time:1000});
                            }else if(data.status==0){
                                layer.msg(data.msg,{icon:5});
                            }
                        }
                    });
                }
            );
        }
    </script>
@endsection