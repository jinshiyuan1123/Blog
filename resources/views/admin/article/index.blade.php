@extends('layouts.admin')

@section('content')
    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> <a href="{{url('admin/index')}}">首页</a>
            <span class="c-gray en">&gt;</span>
            文章管理
            <span class="c-gray en">&gt;</span>
            文章列表
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
        </nav>
        <div class="Hui-article">
            <article class="cl pd-20">
                <div class="text-c">
				<span class="select-box inline">
				<select name="" class="select">
                    <option value="0">全部分类</option>
                    <option value="1">分类一</option>
                    <option value="2">分类二</option>
                </select>
				</span>
                    日期范围：
                    <input type="text" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})" id="logmin" class="input-text Wdate" style="width:120px;">
                    -
                    <input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})" id="logmax" class="input-text Wdate" style="width:120px;">
                    <input type="text" name="" id="" placeholder=" 文章名称" style="width:250px" class="input-text">
                    <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜文章</button>
                </div>
                <div class="cl pd-5 bg-1 bk-gray mt-20">
				<span class="l">
				<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
				<a class="btn btn-primary radius" data-title="添加文章" _href="article-add.html" onclick="admin_article_add('添加文章','{{url("admin/article/create")}}')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加文章</a>
				</span>
                    <span class="r">共有数据：<strong>{{$data->total()}}</strong> 条</span>
                </div>
                <div class="mt-20">
                    {{csrf_field()}}
                    <table class="table table-border table-bordered table-bg table-hover table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
                            <th width="80">ID</th>
                            <th>标题</th>
                            <th width="80">分类</th>
                            <th width="80">作者</th>
                            <th width="120">编辑时间</th>
                            <th width="75">浏览次数</th>
                            <th width="60">文章状态</th>
                            <th width="120">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $v)
                        <tr class="text-c">
                            <td><input type="checkbox" value="" name=""></td>
                            <td>{{$v->art_id}}</td>
                            <td class="text-l"><u style="cursor:pointer" class="text-primary" onClick="article_edit('查看','article-zhang.html','10001')" title="查看">{{$v->art_title}}</u></td>
                            <td>{{$v->cate_name}}</td>
                            <td>{{$v->art_author}}</td>
                            <td>{{$v->art_time}}</td>
                            <td>{{$v->art_view}}</td>
                            <td class="td-status">
                                @if($v->is_show==1 && $v->is_pass==1)
                                    <span class="label label-success radius">已发布</span>
                                @elseif($v->is_show==0 && $v->is_pass==1)
                                    <span class="label label-primary radius">未发布</span>
                                @elseif($v->is_show==0 && $v->is_pass==0)
                                    <span class="label label-info radius">待审核</span>
                                @endif
                            </td>
                            <td class="f-14 td-manage">
                                @if($v->is_show==1 && $v->is_pass==1)
                                    <a style="text-decoration:none" onClick="article_stop(this,{{$v->art_id}})" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>
                                @elseif($v->is_show==0 && $v->is_pass==1)
                                    <a style="text-decoration:none" onClick="article_up(this,{{$v->art_id}})" href="javascript:;" title="上架"><i class="Hui-iconfont">&#xe6dc;</i></a>
                                @elseif($v->is_show==0 && $v->is_pass==0)
                                    <a style="text-decoration:none" onClick="article_shenhe(this,{{$v->art_id}})" href="javascript:;" title="审核">审核</a>
                                @endif
                                <a style="text-decoration:none" class="ml-5" onClick="article_edit('资讯编辑','{{url("admin/article/"."$v->art_id"."/edit")}}')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                                <a style="text-decoration:none" class="ml-5" onClick="article_del(this,{{$v->art_id}})" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                            </td>
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
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/laypage/1.2/laypage.js')}}"></script>
    <script type="text/javascript">
        $('.pagination li').each(function(){
            if($(this).hasClass('disabled')){
                $(this).children('span').css({
                    'background': '#fff',
                    'color': '#666'
                });
            }
        });
        /*文章-添加*/
        function admin_article_add(title,url){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        /*文章-编辑*/
        function article_edit(title,url){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        /*文章-删除*/
        function article_del(obj,id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'delete',
                    url: "{{url('admin/article')}}"+"/"+id,
                    success: function(data){
                        if(data.status==1){
                            $(obj).parents("tr").remove();
                           layer.msg('已删除!',{icon:1,time:1000});
                        }else{
                            layer.msg('已删除!',{icon:5,time:1000});
                        }
                    }
                });
            });
        }

        /*文章-审核*/
        function article_shenhe(obj,id){
            layer.confirm('审核文章？', {
                        btn: ['通过','取消'],
                        shade: false,
                        closeBtn: 0
                    },
                    function(){
                        $.ajax({
                            type:'get',
                            url:"{{url('admin/shenhe')}}"+"/"+id,
                            success:function(data){
                                if(data==1){
                                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="article_up(this,'+id+')" href="javascript:;" title="上架"><i class="Hui-iconfont">&#xe6dc;</i></a>');
                                    $(obj).parents("tr").find(".td-status").html('<span class="label label-primary radius">未发布</span>');
                                    $(obj).remove();
                                    layer.msg('已审核', {icon:6,time:1000});
                                }else{
                                    layer.msg('审核失败', {icon:5,time:1000});
                                }
                            }
                        });
                    });
        }
        /*文章-下架*/
        function article_stop(obj,id){
            layer.confirm('确认要下架吗？',function(index){
                $.ajax({
                    type:'get',
                    url:"{{url('admin/stop')}}"+"/"+id,
                    success:function(data){
                        if(data==1){
                            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="article_shenhe(this,'+id+')" href="javascript:;" title="审核">审核</a>');
                            $(obj).parents("tr").find(".td-status").html('<span class="label label-info radius">待审核</span>');
                            $(obj).remove();
                            layer.msg('已下架!',{icon: 5,time:1000});
                        }else{
                            layer.msg('下架失败!',{icon: 5,time:1000});
                        }
                    }
                });
            });
        }

        /*文章上架*/
        function article_up(obj,id){
            layer.confirm('确认要发布吗？',function(index){
                $.ajax({
                    type:'get',
                    url:"{{url('admin/up')}}"+"/"+id,
                    success:function(data){
                        if(data==1){
                            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="article_stop(this,'+id+')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
                            $(obj).remove();
                            layer.msg('已发布!',{icon: 6,time:1000});
                        }else{
                            layer.msg('发布失败', {icon:5,time:1000});
                        }
                    }
                });
            });
        }
    </script>
@endsection