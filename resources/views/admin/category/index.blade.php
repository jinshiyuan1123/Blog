@extends('layouts.admin')

@section('content')
    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> <a href="{{url('admin/index')}}">首页</a> <span class="c-gray en">&gt;</span> 文章管理 <span class="c-gray en">&gt;</span> 分类列表 <a class="btn btn-success radius r btn-refresh" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="Hui-article">
            <article class="cl pd-20">
                <div class="cl pd-5 bg-1 bk-gray">
                    <span class="l">
                        <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
                        <a class="btn btn-primary radius" href="javascript:;" onclick="admin_category_add('添加分类','{{url("admin/category/create")}}',800,500)"><i class="Hui-iconfont">&#xe600;</i> 添加分类</a>
                    </span>
                    <span class="r">共有数据：<strong>{{count($data)}}</strong> 条</span>
                </div>
                {{csrf_field()}}
                <div class="mt-10">
                    <table class="table table-border table-bordered table-hover table-bg">
                        <thead>
                        <tr>
                            <th scope="col" colspan="7">分类列表</th>
                        </tr>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" value="" name=""></th>
                            <th width="40">ID</th>
                            <th width="200">分类名称</th>
                            <th width="40">排序</th>
                            <th width="300">标题</th>
                            <th>描述</th>
                            <th width="70">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $v)
                            <tr class="text-c">
                                <td><input type="checkbox" value="{{$v->cate_id}}" name=""></td>
                                <td>{{$v->cate_id}}</td>
                                <td style="text-align: left;">{{$v->_cate_name}}</td>
                                <td><input type="text" value="{{$v->cate_order}}" name="" style="width:50%;border-radius: 1px;text-align: center" onchange="changeOrder({{$v->cate_id}},this);"></td>
                                <td>{{$v->cate_title}}</td>
                                <td>{{$v->cate_desc}}</td>
                                <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_category_edit('分类编辑','{{url("admin/category/".$v->cate_id."/edit")}}',800,500)" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_category_del(this,{{$v->cate_id}})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection


@section('javascriptfooter')
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/laypage/1.2/laypage.js')}}"></script>
    <script type="text/javascript">
        function changeOrder(cate_id,obj){
            $.ajax({
                url:"{{url('admin/changeOrder').'/'}}"+cate_id+'/cate_order/'+obj.value,
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
        function admin_category_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*分类-编辑*/
        function admin_category_edit(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*管理员-角色-删除*/
        function admin_category_del(obj,id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });
            layer.confirm(
                '分类删除须谨慎，确认要删除吗？',
                function(index){
                    $.ajax({
                        type:'delete',
                        url:"{{url('admin/category')}}"+"/"+id,
                        success:function(data){
                            if(data.status==1){
                                $(obj).parents("tr").remove();
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