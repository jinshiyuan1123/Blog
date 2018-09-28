@extends('layouts.admin')
@section('content')

    <div class="page-container" style="margin-left: 80px;">
        <form class="form form-horizontal" id="form-pass-edit" method="post">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>原密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="请输入旧密码" id="" name="oldpass">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>新密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="请输入新密码" id="password" name="password">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>确认密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="请重新输入新密码" name="password_confirmation">
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </div>
    </div>
@endsection


@section('javascriptfooter')
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
    <script>
        $(function(){
            $("#form-pass-edit").validate({
                rules:{
                    oldpass:{
                        required:true,
                    },
                    newpass:{
                        required:true,
                        minlength:6,
                        maxlength:20
                    },
                    confirmpass:{
                        required:true,
                        equalTo: "#password"
                    },
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        url:"{{url('admin/pass')}}",
                        type:'post',
                        success:function(resp){
                            if(resp!=0 && resp!=1){
                                res= JSON.parse(resp);
                                alert(res);
                            }else if(resp==0){
                                layer.alert('原密码输入错误', {
                                    skin: 'layui-layer-molv' //样式类名
                                    ,closeBtn: 0
                                });
                                $('input[name=oldpass]').val('');
                                $('input[name=oldpass]').focus();
                            }else if(resp==1){
                                layer.alert('密码修改成功', {
                                    skin: 'layui-layer-molv' //样式类名
                                    ,closeBtn: 0
                                },function(){
                                    window.location="{{url('admin/index')}}";
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>

@endsection