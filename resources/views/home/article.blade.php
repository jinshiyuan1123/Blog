@extends('layouts.home')


@section('intro')

@endsection
@section('title')
    <title>国民的博客--{{$content->art_title}}</title>
    <meta charset="utf-8" />
    <meta name="keywords" content="{{$content->art_tag}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
@endsection

@section('content')
    <div id="main">
        <input type="hidden" value="{{$catename}}" class="catename">
        <!-- Post -->
        <section class="post">
            <header class="major">
                <span class="date">{{$content->art_time}}</span>
                <h1>{{$content->art_title}}</h1>
                <p>{{$content->art_desc}}</p>
            </header>
            {!! $content->art_content !!}
        </section>

    </div>

    <footer id="footer">

        <section class="post">
            <form method="post" action="#" class="alt">
                <div class="row uniform">
                    <div class="6u 12u$(xsmall)">
                        <input type="text" name="demo-name" id="demo-name" value="" placeholder="昵称" />
                    </div>
                    <div class="6u$ 12u$(xsmall)">
                        <input type="email" name="demo-email" id="demo-email" value="" placeholder="邮箱" />
                    </div>
                    <!-- Break -->
                    <div class="12u$">
                        <textarea name="demo-message" id="demo-message" placeholder="请在这里评论一发" rows="6"></textarea>
                    </div>
                    <!-- Break -->
                    <div class="12u$">
                        <ul class="actions">
                            <li><input type="button" value="Send Message" class="special" /></li>
                            <li><input type="reset" value="Reset" /></li>
                        </ul>
                    </div>
                </div>
            </form>
        </section>
    </footer>
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
            $('.special').click(function(){
                alert('此功能尚未开发');
                return false;
            });
        });
    </script>
@endsection