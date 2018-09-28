@extends('layouts.home')

@section('content')
    <style>
        #nav{
            /*display: none;*/
        }
    </style>
    <div id="main">
        @foreach($article as $k=> $v)
            @if($k==0)
                <!-- Featured Post -->
                <article class="post featured">
                    <header class="major">
                        <span class="date">{{$v->art_time}}</span>
                        <h2><a href="{{url('article/'.$v->art_id)}}">{{$v->art_title}}</a></h2>
                        <p>{{$v->art_desc}}</p>
                    </header>
                    <a href="{{url('article/'.$v->art_id)}}" class="image main"><img src="{{asset($v->art_thumb)}}" alt="" /></a>
                    <ul class="actions">
                        <li><a href="{{url('article/'.$v->art_id)}}" class="button big">查看全文</a></li>
                    </ul>
                </article>
             <section class="posts">
                 <!-- Posts -->
            @endif
                @if($k!=0)
                    <article>
                        <header>
                            <span class="date">{{$v->art_time}}</span>
                            <h2><a href="{{url('article/'.$v->art_id)}}">{{$v->art_title}}</a></h2>
                        </header>
                        <a href="{{url('article/'.$v->art_id)}}" class="image fit"><img src="{{asset($v->art_thumb)}}" alt="{{$v->art_title}}" /></a>
                        <p>{{$v->art_desc}}</p>
                        <ul class="actions">
                            <li><a href="{{url('article/'.$v->art_id)}}" class="button">查看全文</a></li>
                        </ul>
                    </article>
                @endif
             @if(count($article)==($k+1))
             </section>
             @endif

        @endforeach
        <!-- Footer -->


    </div>
@endsection

@section('jscontent')

@endsection