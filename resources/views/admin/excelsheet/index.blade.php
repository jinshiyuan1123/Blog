@extends('layouts.admin')

@section('content')
    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> <a href="{{url('admin/index')}}">首页</a>
            <span class="c-gray en">&gt;</span>
            报表管理
            <span class="c-gray en">&gt;</span>
            报表管理
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
                    导入日期：
                    <input type="text" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})" id="logmin" class="input-text Wdate" style="width:120px;">
                    -
                    <input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})" id="logmax" class="input-text Wdate" style="width:120px;">
                    <input type="text" name="" id="" placeholder=" 文章名称" style="width:250px" class="input-text">
                    <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜文章</button>
                </div>
                <div class="cl pd-5 bg-1 bk-gray mt-20">
				<span class="l">
				<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe644;</i> 导出</a>

				<a class="btn btn-primary radius" data-title="导入"  onclick="importExcel()" ><i class="Hui-iconfont">&#xe645;</i> 导入</a>
				</span>
                    <span class="r">共有数据：<strong>{{$data->total()}}</strong> 条</span>
                </div>
                <div class="mt-20">
                    <div id="filePicker"></div>
                    <table class="table table-border table-bordered table-bg table-hover table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
                            <th width="80">ID</th>
                            <th>内容</th>
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
                                    <td>{{$v->id}}</td>
                                    <td class="text-l"><u style="cursor:pointer" class="text-primary" onClick="article_edit('查看','article-zhang.html','10001')" title="查看">{{mb_substr($v->content,1,50)}}</u></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="td-status"> </td>
                                    <td class="f-14 td-manage"></td>
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
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/webuploader/0.1.5/webuploader.min.js')}}"></script>
    <script type="text/javascript">
        function importExcel(){
            var div=$('.webuploader-pick').next('div');
            var input=div.children('input');
            input.trigger('click');
        }
        $(function(){
            state = "pending",
                uploader;

            var uploader = WebUploader.create({
                auto: true,
                swf: "{{asset('resources/views/admin/lib/webuploader/0.1.5/Uploader.swf')}}",
                formData:{
                    '_token':'{{csrf_token()}}'
                },
                // 文件接收服务端。
                server: '{{url("admin/import")}}',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',

                // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                resize: false,
                accept: {
                    title: 'file',
                    extensions: 'xls,docx,xlsx,pptx',
                    mimeTypes: 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.presentationml.presentation'
                }
            });


            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on( 'uploadSuccess', function( file,response ) {
                layer.msg('导入成功...');
                window.location.reload();
            });
            // 文件上传失败，显示上传出错。
            uploader.on( 'uploadError', function( file ) {
                layer.msg('导入失败');
            });
            uploader.on('all', function (type) {
                if (type === 'startUpload') {
                    state = 'uploading';
                } else if (type === 'stopUpload') {
                    state = 'paused';
                } else if (type === 'uploadFinished') {
                    state = 'done';
                }

            });

        });
    </script>

@endsection

