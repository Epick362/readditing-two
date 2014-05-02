<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Readditing.com | {{ $subreddit or 'Seamless reddit experience' }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('packages/bootstrap/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('packages/bootstrap/css/bootstrap-theme.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/stylesheet.css') }}">
		<link href='http://fonts.googleapis.com/css?family=Lato:100,400,700' rel='stylesheet' type='text/css'>
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
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
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
					</ul>
					<ul class="nav navbar-nav navbar-right">
						@if(!Session::has('user'))
							<a href="{{ URL::to('auth/login') }}" class="btn btn-default navbar-btn">Sign in with Reddit</a>
						@else
							<li><a href="#">{{ Session::get('user')['name'] }}</a></li>
						@endif
					</ul>
				</div>
			</div>
		</div>

		<div class="container">
			@yield('content')
		</div>

		<script>
			TOKEN = {{ $token or "" }};
		</script>
		<script src="{{ URL::asset('packages/angular.js/angular.min.js') }}"></script>
		<script src="{{ URL::asset('packages/jquery/jquery.min.js') }}"></script>
		<script src="{{ URL::asset('packages/bootstrap/js/bootstrap.min.js') }}"></script>
		<script src="{{ URL::asset('js/main.js') }}"></script>
	</body>
</html>
