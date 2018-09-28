@extends('layouts.admin')
@section('header')

@endsection


@section('menu')

@endsection

@section('content')
    <link rel="stylesheet" href="{{asset('resources/views/admin/lib/webuploader/0.1.5/webuploader.css')}}">
    <article class="page-container">
        <form class="form form-horizontal" id="form-article-edit">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>文章标题：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$data->art_title}}" placeholder="" id="" name="art_title">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类栏目：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box"style="width: 27%;">
				<select name="art_pid" class="select">
                    <option value="">请选择分类</option>
                    @foreach($cate as $v)
                        <option value="{{$v->cate_id}}" data="{{$v->cate_pid}}" @if($data->art_pid==$v->cate_id) selected @endif>
                            {{$v->_cate_name}}
                        </option>
                    @endforeach
                </select>
				</span> </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">文章作者：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder=""value="{{$data->art_author}}" id="" name="art_author" style="width: 27%;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">缩略图：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <input type="text" class="input-text" value="{{$data->art_thumb}}" readonly id="art_thumb" name="art_thumb"/>
                        <div id="fileList" class="uploader-list" ></div>
                        <div id="filePicker">选择图片</div>
                        <button id="btn-star" class="btn btn-default btn-uploadstar radius ml-10">开始上传</button>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">关键词：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$data->art_tag}}" placeholder="" id="" name="art_tag">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">文章摘要：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="art_desc" cols="" rows="" class="textarea"   nullmsg="备注不能为空！">{{$data->art_desc}}</textarea>

                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">文章内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <script id="editor" name="art_content" type="text/plain" style="width:100%;height:400px;">{!! $data->art_content !!}</script>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存修改</button>
                    <button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                </div>
            </div>
        </form>
    </article>
@endsection



@section('javascriptfooter')
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/webuploader/0.1.5/webuploader.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/ueditor/1.4.3/ueditor.config.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/ueditor/1.4.3/ueditor.all.min.js')}}"> </script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js')}}"></script>
    <script type="text/javascript">

        function removeIframe(){
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        }
        $(function(){
            $list = $("#fileList"),
                    $btn = $("#btn-star"),
                    state = "pending",
                    uploader;

            var uploader = WebUploader.create({
                auto: true,
                swf: "{{asset('resources/views/admin/lib/webuploader/0.1.5/Uploader.swf')}}",
                formData:{
                    '_token':'{{csrf_token()}}'
                },
                // 文件接收服务端。
                server: '{{url("admin/upload")}}',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',

                // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                resize: false,
                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }
            });
            uploader.on( 'fileQueued', function( file ) {
                var $li = $(
                                '<div id="' + file.id + '" class="item">' +
                                '<div class="pic-box"><img></div>'+
                                '<div class="info">' + file.name + '</div>' +
                                '<p class="state">等待上传...</p>'+
                                '</div>'
                        ),
                        $img = $li.find('img');
                $list.append( $li );

                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
                uploader.makeThumb( file, function( error, src ) {
                    if ( error ) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }

                    $img.attr( 'src', src );
                }, 100, 100 );
            });
            // 文件上传过程中创建进度条实时显示。
            uploader.on( 'uploadProgress', function( file, percentage ) {
                var $li = $( '#'+file.id ),
                        $percent = $li.find('.progress-box .sr-only');

                // 避免重复创建
                if ( !$percent.length ) {
                    $percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo( $li ).find('.sr-only');
                }
                $li.find(".state").text("上传中");
                $percent.css( 'width', percentage * 100 + '%' );
            });

            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on( 'uploadSuccess', function( file,response ) {
                $('#art_thumb').val(response._raw);
                $( '#'+file.id ).addClass('upload-state-success').find(".state").text("已上传");
            });

            // 文件上传失败，显示上传出错。
            uploader.on( 'uploadError', function( file ) {
                $( '#'+file.id ).addClass('upload-state-error').find(".state").text("上传出错");
            });

            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on( 'uploadComplete', function( file ) {

                $( '#'+file.id ).find('.progress-box').fadeOut();
            });
            uploader.on('all', function (type) {
                if (type === 'startUpload') {
                    state = 'uploading';
                } else if (type === 'stopUpload') {
                    state = 'paused';
                } else if (type === 'uploadFinished') {
                    state = 'done';
                }

                if (state === 'uploading') {
                    $btn.text('暂停上传');
                } else {
                    $btn.text('开始上传');
                }
            });

            $btn.on('click', function () {
                if (state === 'uploading') {
                    uploader.stop();
                } else {
                    uploader.upload();
                }
            });

            var ue = UE.getEditor('editor');

            $("#form-article-edit").validate({
                rules:{
                    art_title:{
                        required:true
                    },
                    art_pid:{
                        required:true
                    },
                    art_author:{
                        required:true,
                    },
                    art_thumb:{
                        required:true,
                    },
                    art_tag:{
                        required:true,
                    },

                    art_desc:{
                        required:true,
                    },
                    art_content:{
                        required:true,
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        url:"{{url('admin/article/'.$data->art_id)}}",
                        type:'put',
                        success:function(data){
                            if(data.status==1){
                                layer.msg(data.msg,{icon:6},function(){
                                    var index = parent.layer.getFrameIndex(window.name);
                                    parent.window.location.reload();
                                    parent.layer.close(index);
                                });
                            }else if(data.status==0){
                                layer.msg(data.msg,{icon:5});
                            }
                        }
                    });
                }
            });

        });
    </script>
@endsection