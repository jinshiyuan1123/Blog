@extends('layouts.admin')


@section('header')

@endsection


@section('menu')

@endsection

@section('content')
    <article class="cl pd-20">
        <form action="" method="post" class="form form-horizontal" id="form-category-edit">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>分类名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$data->cate_name}}" placeholder="请输入分类名称"  name="cate_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$data->cate_order}}" placeholder="" name="cate_order" style="width: 27%;">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>分类标题：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$data->cate_title}}" placeholder="请输入分类标题" name="cate_title">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">关键词：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$data->cate_keywords}}" placeholder="请输入关键词" name="cate_keywords">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">描述：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="cate_desc" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true">{{$data->cate_desc}}</textarea>

                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
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

            $("#form-category-edit").validate({
                rules:{
                    cate_name:{
                        required:true,
                        minlength:4,
                        maxlength:16
                    },
                    cate_order:{
                        required:true,
                        isNumber:true
                    },
                    cate_title:{
                        required:true,
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        url:"{{url('admin/category/'.$data->cate_id)}}",
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