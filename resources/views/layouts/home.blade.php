<!DOCTYPE HTML>
<html>
	<head>
		@section('title')
        <title>国民的博客</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        @show
		<link rel="stylesheet" href="{{asset('resources/views/home/assets/css/main.css')}}" />
		<noscript><link rel="stylesheet" href="{{asset('resources/views/home/assets/css/noscript.css')}}" /></noscript>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper" class="fade-in">
                    @section('intro')
				    <!-- Intro -->
					<div id="intro">
						<h1>欢迎进入<br />
						iGuomin博客</h1>
						<p>这里有很多实用的技术性文章<br />
						或者生活中的趣事，ALL over here</p>
						<ul class="actions">
							<li><a href="#header" class="button icon solo fa-arrow-down scrolly">继续</a></li>
						</ul>
					</div>
                    @show
				<!-- Header -->
					<header id="header">
						<a href="{{url('/')}}" class="logo">iguomin</a>
					</header>
				    <!-- Nav -->
					<nav id="nav">
						<ul class="links">
                            <li><a href="{{url('/')}}">首页</a></li>
                            @foreach($nav as $v)
							<li ><a href="{{url('/cate/'.$v->cate_id)}}">{{$v->cate_name}}</a></li>
                             @endforeach
						</ul>

					</nav>
				<!-- Main -->
					@yield('content')

				<!-- Copyright -->
					<div id="copyright">
						<ul><li>&copy; 博客</li><li><a href="mailto:yushi5344@gmail.com">yushi5344@gmail.com</a></li></ul>
					</div>

			</div>

		<!-- Scripts -->
			<script src="{{asset('resources/views/home/assets/js/jquery.min.js')}}"></script>
			<script src="{{asset('resources/views/home/assets/js/jquery.scrollex.min.js')}}"></script>
			<script src="{{asset('resources/views/home/assets/js/jquery.scrolly.min.js')}}"></script>
			<script src="{{asset('resources/views/home/assets/js/skel.min.js')}}"></script>
			<script src="{{asset('resources/views/home/assets/js/util.js')}}"></script>
			<script src="{{asset('resources/views/home/assets/js/main.js')}}"></script>
        <script>
            $(function(){
                $(function(){
                    $('.pagination li').eq(0).addClass('previous');
                    $('.pagination li:last').addClass('next');
                });
                var url=location.href;//http://localhost/blog/
                var cate=url.indexOf('/cate/');
                var art=url.indexOf('/article/');

                if(cate==-1 && art==-1){
                    $('.links li').eq(0).addClass('active');
                }
                //alert(cate+'|'+art);


            });
        </script>
            @yield('jscontent')
	</body>
</html>