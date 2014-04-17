<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Blog, from you</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('packages/bootstrap/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('packages/bootstrap/css/bootstrap-theme.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/stylesheet.css') }}">
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
				</div>
			</div>
		</div>

		<div class="container">
			<div>
				<h1>Bootstrap starter template</h1>
				<p class="lead">@yield('content')</p>
			</div>
		</div>

		<script src="{{ URL::asset('packages/jquery/jquery.min.js') }}"></script>
		<script src="{{ URL::asset('packages/underscore/underscore-min.js') }}"></script>
		<script src="{{ URL::asset('packages/backbone/backbone-min.js') }}"></script>
		<script src="{{ URL::asset('packages/bootstrap/js/bootstrap.min.js') }}"></script>
		<script src="{{ URL::asset('js/main.js') }}"></script>
	</body>
</html>
