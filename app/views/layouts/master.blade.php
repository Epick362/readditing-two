<!DOCTYPE html>
<html lang="en" ng-app="readditingApp" >
	<head>
		<meta charset="utf-8">
		<title>Readditing | @yield('title', 'better reddit experience')</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="@yield('meta-desc', 'Your main source of information, stories and entertainment. You can find anything on Readditing.')">
		<meta name="keywords" content="reddit social friends news information readdit readditing">
		<meta name="author" content="Filip Hajek">

		@section('og')
		<!-- Open Graph data -->
		<meta property="og:title" content="Readditing.com | @yield('title', 'better reddit experience')" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://www.readditing.com/" />
		<meta property="og:image" content="{{ URL::to('apple-touch-icon-120x120.png') }}" />
		<meta property="og:description" content="@yield('meta-desc', 'Your main source of information, stories and entertainment. You can find anything on Readditing.')" />
		@show

		<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
		<link rel="icon" type="image/png" href="/favicon-196x196.png" sizes="196x196">
		<link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160">
		<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
		<meta name="msapplication-TileColor" content="#2b5797">
		<meta name="msapplication-TileImage" content="/mstile-144x144.png">
		
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app/styles/main.css') }}">

		<link id="ApiRoot" href="{{ URL::to('') }}" />
	</head>
	@section('body')
	<body>
	@show
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
				@if(!Session::has('user'))
					<a href="{{ URL::to('auth/login') }}" class="btn btn-default navbar-btn hidden-md hidden-lg hidden-md hidden-sm" analytics-on analytics-category="Login">Sign in with <i class="fa fa-lock"></i> Reddit</a>
        		@endif
        			<button type="button" class="navbar-toggle" ng-init="navCollapsed = true" ng-click="navCollapsed = !navCollapsed">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ URL::to('') }}" target="_self">
						<div class="brand-image">r</div>
					</a>
				</div>
				<div class="collapse navbar-collapse" ng-class="{'in': !navCollapsed}">
					<ul class="nav navbar-nav">
						<li class="{{ Request::is('submit') ? 'active' : '' }}"><a href="{{ URL::to('submit') }}" analytics-on>Submit</a></li>
						<li class="{{ Request::is('r/readditingcom') ? 'active' : '' }}"><a href="{{ URL::to('r/readditingcom') }}">Blog</a></li>
						<li class="{{ Request::is('about') ? 'active' : '' }}"><a href="{{ URL::to('about') }}">About</a></li>
					</ul>

					@yield('nav-middle')

					<ul class="nav navbar-nav navbar-right">
						@if(!Session::has('user'))
							<a href="{{ URL::to('auth/login') }}" class="btn btn-default navbar-btn hidden-xs" analytics-on analytics-category="Login">Sign in with <i class="fa fa-lock"></i> Reddit</a>
		        		@else
							<li>
								<a href="{{ URL::to('u/'.Session::get('user')['name']) }}"><i class="fa fa-user"></i> {{ Session::get('user.name') }}</a>
							</li>
							<li>
								<a href="{{ URL::to('logout') }}" class="logout" analytics-on analytics-category="Logout">Logout <i class="fa fa-sign-out"></i></a>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</div>

		@section('wrap')
		<div id="wrap">
			<div class="container">
				<div class="row">
					@yield('content')
				</div>
			</div>
		</div>
		@show

		<a href="#" class="btn btn-default btn-to-top"><i class="fa fa-chevron-up"></i></a>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/history.js/1.8/bundled/html4+html5/jquery.history.js"></script>
		
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script> <!-- load angular -->
		<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.0.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js"></script>
		<script src="https://cdn.jsdelivr.net/angular.moment/0.8.0/angular-moment.min.js"></script>
		<script src="{{ URL::asset('app/scripts/ngSanitize.js') }}"></script>
		<script src="{{ URL::asset('app/scripts/ng-infinite-scroll.min.js') }}"></script>
		<script src="{{ URL::asset('app/scripts/elastic.js') }}"></script>

		<script src="{{ URL::asset('app/scripts/angulartics.min.js') }}"></script>
		<script src="{{ URL::asset('app/scripts/angulartics-ga.min.js') }}"></script>
		
		<script src="{{ URL::asset('js/app.js') }}"></script>
		<script src="{{ URL::asset('js/controllers/channelController.js') }}"></script>
		<script src="{{ URL::asset('js/services/channelService.js') }}"></script>

		<script type="text/javascript">
			$(function() {
				$(window).on('beforeunload', function() {
				    $(window).scrollTop(0);
				});			
			});
		</script>

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-46225304-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
</html>
