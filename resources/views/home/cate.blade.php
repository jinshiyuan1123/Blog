@extends('layouts.home')
@section('intro')

@endsection
@section('title')
    <title>国民的博客--{{$catename}}</title>
    <meta charset="utf-8" />
    <meta name="keywords" content="{{$catename}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
@endsection
@section('content')
    <div id="main">
        <input type="hidden" value="{{$catename}}" class="catename">
        <section>
            <ul class="dates">
                @if(count($article))
                    @foreach($article as $v)
                    <li>
                        <span class="date">{{date('M',strtotime($v->art_time))}} <strong>{{date('d',strtotime($v->art_time))}}</strong></span>
                        <h3><a href="{{url('/article/'.$v->art_id)}}">{{$v->art_title}}</a></h3>
                        <p class="art_view">点击量：{{$v->art_view}} </p>
                        <p>标签：{{$v->art_tag}}</p>
                    </li>
                    @endforeach
                 @else
                    本类下暂无内容
                @endif
            </ul>
        </section>
        <footer>
            {{$article->links()}}
        </footer>
    </div>

@endsection

@section('jscontent')
    <script>
        $(function(){
           $('.links li').each(function(index){
               if($(this).children('a').text()==$('.catename').val()){
                   $('.links li').removeClass('active');
                   $(this).addClass('active');
               }
           });
        });
    </script>
@endsection