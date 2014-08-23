<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Readditing.com | {{ $subreddit or 'Seamless reddit experience' }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app/styles/main.css') }}">

		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script> <!-- load angular -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.10.0/ui-bootstrap.min.js"></script>
		<script src="http://code.angularjs.org/1.0.1/angular-sanitize-1.0.1.js "></script>
		<script src="{{ URL::asset('app/scripts/ng-infinite-scroll.min.js') }}"></script>
		
		<script src="{{ URL::asset('js/services/subredditService.js') }}"></script>
		<script src="{{ URL::asset('js/controllers/subredditCtrl.js') }}"></script>
		<script src="{{ URL::asset('js/app.js') }}"></script>
	</head>
	<body>
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ URL::to('') }}">Readditing</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#about">About</a></li>
						<li><a href="#contact">Contact</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						@if(!Session::has('user'))
							<a href="{{ URL::to('auth/login') }}" class="btn btn-default navbar-btn">Sign in with Reddit</a>
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
				<div class="row" style="position: relative">
					<div class="col-lg-8 col-lg-offset-1">
						@yield('content')
					</div>
					<div class="col-lg-2" style="position: fixed; top: 0">
						Yaya
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
