@extends('layouts.admin')

@section('content')
    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> <a href="{{url('admin/index')}}">首页</a> <span class="c-gray en">&gt;</span> 配置管理 <span class="c-gray en">&gt;</span> 配置列表 <a class="btn btn-success radius r btn-refresh" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="Hui-article">
            <article class="cl pd-20">
                <div class="cl pd-5 bg-1 bk-gray">
                    <span class="l">
                        <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
                        <a class="btn btn-primary radius" href="javascript:;" onclick="admin_conf_add('添加配置','{{url("admin/conf/create")}}',800,500)"><i class="Hui-iconfont">&#xe600;</i> 添加配置</a>
                    </span>
                    <span class="r">共有数据：<strong>{{count($data)}}</strong> 条</span>
                </div>
                {{csrf_field()}}
                <div class="mt-10">
                    <form action="" id="conf_multi_edit">
                        {{csrf_field()}}
                        <table class="table table-border table-bordered table-hover table-bg">
                            <thead>
                            <tr>
                                <th scope="col" colspan="7">配置列表</th>
                            </tr>
                            <tr class="text-c">
                                <th width="25"><input type="checkbox" value="" name=""></th>
                                <th width="40">ID</th>
                                <th width="150">名称</th>
                                <th width="40">排序</th>
                                <th width="200">标题</th>
                                <th>内容</th>
                                <th width="70">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                                <tr class="text-c">
                                    <td><input type="checkbox" value="{{$v->conf_id}}" name=""></td>
                                    <td>{{$v->conf_id}}</td>
                                    <td style="text-align: left;">{{$v->conf_name}}</td>
                                    <td><input type="text" value="{{$v->conf_order}}" name="" style="width:50%;border-radius: 1px;text-align: center" onchange="changeOrder({{$v->conf_id}},this);"></td>
                                    <td>{{$v->conf_title}}</td>
                                    <td>{!! $v->conf_content !!}</td>
                                    <td class="f-14"> <a title="删除" href="javascript:;" onclick="admin_conf_del(this,{{$v->conf_id}})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tr>
                                <th scope="col" colspan="7">
                                    <div class="row cl">
                                        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                                            <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </table>
                    </form>
                </div>
            </article>
        </div>
    </section>
@endsection


@section('javascriptfooter')
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/laypage/1.2/laypage.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
    <script type="text/javascript">
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
        $('#conf_multi_edit').validate({
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    url:"{{url('admin/multi_edit')}}",
                    type:'post',
                    success:function(data){
                        layer.msg(data,{icon:6});
                    }
                });
            }
        });
        function changeOrder(conf_id,obj){
            $.ajax({
                url:"{{url('admin/changeConfOrder').'/'}}"+conf_id+'/conf_order/'+obj.value,
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
        function admin_conf_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*分类-编辑*/
        function admin_conf_edit(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*管理员-角色-删除*/
        function admin_conf_del(obj,id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });
            layer.confirm(
                    '配置删除须谨慎，确认要删除吗？',
                    function(index){
                        $.ajax({
                            type:'delete',
                            url:"{{url('admin/conf')}}"+"/"+id,
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