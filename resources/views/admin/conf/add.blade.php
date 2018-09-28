@extends('layouts.admin')
@section('header')

@endsection


@section('menu')

@endsection
@section('content')
    <article class="cl pd-20">
        <form action="" method="post" class="form form-horizontal" id="form-conf-add">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>配置名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" id="website-title" placeholder="控制在25个字、50个字节以内" value="" class="input-text" name="conf_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>标题：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" id="website-Keywords" placeholder="" value="" class="input-text" name="conf_title">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>类型：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal show_type">
                    <div class="radio-box">
                        <input name="field_type" value="1" type="radio" id="field_type-1" checked>
                        <label for="field_type-1">input</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" value="2" id="field_type-2" name="field_type">
                        <label for="field_type-2">textarea</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" value="3" id="field_type-3" name="field_type">
                        <label for="field_type-3">radio</label>
                    </div>
                </div>
            </div>
            <div class="row cl type_show" style="display: none">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>类型值：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input name="field_value" value="1" type="radio" id="field_value-1" checked>
                        <label for="field_value-1">开启</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" value="0" id="field_value-2" name="field_value">
                        <label for="field_value-2">关闭</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>排序：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" id="website-uploadfile" name="conf_order" placeholder="" value="" class="input-text" style="width: 27%;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>说明：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text"  name="conf_tips" placeholder="" value="" class="input-text">
                </div>
            </div>
            <div class="row cl conf_content">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea class="textarea" name="conf_content"></textarea>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
                    <button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                </div>
            </div>
        </form>
    </article>
@endsection

@section('javascriptfooter')
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            $('.show_type input').on('ifChecked', function(event){ //ifChecked 事件应该在插件初始化之前绑定
                if($(this).val()==3){
                    $('.type_show').show();
                    $('.conf_content').hide();
                }else{
                    $('.type_show').hide();
                    $('.conf_content').show();
                }

            });
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });
            $("#form-conf-add").validate({
                rules:{
                    conf_name:{
                        required:true,
                    },
                    conf_order:{
                        required:true,
                        isNumber:true
                    },
                    conf_title:{
                        required:true,
                    },
                    conf_tips:{
                        required:true,
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        url:"{{url('admin/conf')}}",
                        type:'post',
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