<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Readditing.com | {{ $subreddit or 'Seamless reddit experience' }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

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

		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script> <!-- load angular -->
		<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.0.js"></script>
		<script src="http://code.angularjs.org/1.0.1/angular-sanitize-1.0.1.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js"></script>
		<script src="https://cdn.jsdelivr.net/angular.moment/0.8.0/angular-moment.min.js"></script>
		<script src="{{ URL::asset('app/scripts/ng-infinite-scroll.min.js') }}"></script>
		<script src="{{ URL::asset('app/scripts/kudos.js') }}"></script>
		
		<script src="{{ URL::asset('js/services/subredditService.js') }}"></script>
		<script src="{{ URL::asset('js/controllers/subredditCtrl.js') }}"></script>
		<script src="{{ URL::asset('js/app.js') }}"></script>
	</head>
	<body ng-app="subredditApp">
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" ng-init="navCollapsed = false" ng-click="navCollapsed = !navCollapsed" class="navbar-toggle">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ URL::to('') }}">
						<div class="brand-image">r</div>
					</a>
				</div>
				<div class="nav-collapse" collapse="navCollapsed">
					<ul class="nav navbar-nav">
						<li class="{{ Request::is('') ? 'active' : '' }}"><a href="{{ URL::to('/') }}">Browse</a></li>
						<li><a href="http://blog.readditing.com">Blog</a></li>
						<li class="{{ Request::is('about') ? 'active' : '' }}"><a href="{{ URL::to('about') }}">About</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						@if(!Session::has('user'))
							<a href="{{ URL::to('auth/login') }}" class="btn btn-default navbar-btn">Sign in with <i class="fa fa-lock"></i> Reddit</a>
						@else
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> {{ Session::get('user')['name'] }} <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li class="divider"></li>
									<li class="dropdown-header">Nav header</li>
									<li><a href="#">Separated link</a></li>
									<li><a href="#">One more separated link</a></li>
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
					<div class="col-md-8 col-md-offset-1">
						@yield('content')
					</div>
					<div class="col-md-3 visible-md visible-lg">
						@include('partials.sidebar')
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
