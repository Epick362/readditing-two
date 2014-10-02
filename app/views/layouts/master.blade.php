<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Readditing | @yield('title', 'better reddit experience')</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="Readditing is a social reddit website">
		<meta name="keywords" content="reddit social friends news information readdit readditing">
		<meta name="author" content="Filip Hajek">

		@section('og')
		<!-- Open Graph data -->
		<meta property="og:title" content="Readditing.com | @yield('title', 'better reddit experience')" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://www.readditing.com/" />
		<meta property="og:image" content="{{ URL::to('apple-touch-icon-120x120.png') }}" />
		<meta property="og:description" content="Readditing is a social reddit website" />
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
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app/styles/kudos.css') }}">

		<link id="ApiRoot" href="{{ URL::to('') }}" />
	</head>
	@section('body')
	<body ng-app="readditingApp">
	@show
		<!-- BuySellAds Ad Code -->
		<script type="text/javascript">
		(function(){
		  var bsa = document.createElement('script');
		     bsa.type = 'text/javascript';
		     bsa.async = true;
		     bsa.src = 'http://s3.buysellads.com/ac/bsa.js';
		  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
		})();
		</script>
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
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
							<a style="margin-left:10px;" href="{{ URL::to('auth/login') }}" class="btn btn-default navbar-btn" analytics-on analytics-event="Login">Sign in with <i class="fa fa-lock"></i> Reddit</a>
						@else
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> {{ Session::get('user')['name'] }} <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li class="dropdown-header">My profile</li>
									<li><a href="{{ URL::to('u/'.Session::get('user')['name']) }}">Overview</a></li>
									<li><a href="{{ URL::to('u/'.Session::get('user')['name'].'/submitted') }}">Submitted</a></li>
									<li><a href="{{ URL::to('u/'.Session::get('user')['name'].'/liked') }}">Liked</a></li>
									<li><a href="{{ URL::to('u/'.Session::get('user')['name'].'/saved') }}">Saved</a></li>
									<li class="divider"></li>
									<li><a href="{{ URL::to('logout') }}" analytics-on>Logout</a></li>
								</ul>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</div>

		<div id="wrap">
			<div class="container">
				<div class="row">
					@yield('content')
				</div>
			</div>
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/history.js/1.8/bundled/html4+html5/jquery.history.js"></script>
		
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script> <!-- load angular -->
		<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.0.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js"></script>
		<script src="https://cdn.jsdelivr.net/angular.moment/0.8.0/angular-moment.min.js"></script>
		<script src="{{ URL::asset('app/scripts/ngSanitize.js') }}"></script>
		<script src="{{ URL::asset('app/scripts/ng-infinite-scroll.min.js') }}"></script>
		<script src="{{ URL::asset('app/scripts/kudos.js') }}"></script>

		<script src="{{ URL::asset('app/scripts/angulartics.min.js') }}"></script>
		<script src="{{ URL::asset('app/scripts/angulartics-ga.min.js') }}"></script>
		
		<script src="{{ URL::asset('js/services/subredditService.js') }}"></script>
		<script src="{{ URL::asset('js/controllers/subredditCtrl.js') }}"></script>
		<script src="{{ URL::asset('js/app.js') }}"></script>

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-46225304-3', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
</html>
