@extends('layouts.master')

@section('title')
	{{ $post['title'] }} by {{ $post['author'] }}
@stop

@section('og')
	<!-- Open Graph data -->
	<meta property="og:site_name" content="Readditing.com" />
	<meta property="og:locale" content="en_GB" />
	<meta property="og:title" content="{{ $post['title'] }} by {{ $post['author'] }}" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="{{ Request::url() }}" />
	<meta property="og:image" content="{{ URL::to('apple-touch-icon-120x120.png') }}" />
	<meta property="og:description" content="{{ substr(strip_tags($post['content']), 0, 200) }}" />
@overwrite

@section('body')
	<body 
		ng-app="readditingApp" 
		ng-controller="subredditController" 
		user="{{ $username or false }}" 
		subreddit="{{ $subreddit or false }}" 
	>
@overwrite

@section('nav-middle')
	<div class="col-sm-4 col-md-4">
		<form ng-submit="jumpTo()" class="navbar-form">
			<div class="input-group">
				<span class="input-group-addon">/r/</span>
				<input type="text" ng-model="sr" placeholder="{{ $subreddit or 'subreddit' }}" class="form-control col-sm-3 col-md-4" required>
				<div class="input-group-btn">
					<button type="submit" class="btn btn-primary">Go</button>
				</div>
			</div>
		</form>
	</div>
@stop

@section('content')
	<div class="col-md-8 col-md-offset-1">
		<div class="ad-leaderboard">
			<div id="bsap_1299172" class="bsarocks bsap_e5b2c2361c9aa558f3aae3449b24de26"></div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				{{ $post['title'] }}
				<a class="pull-right" href="{{ $post['url'] }}" target="_blank" rel="nofollow">{{ $post['source'] }}</a>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body" show-more>
				{{ $post['content'] }}
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4">
						<a href="{{ URL::to('u/'.$post['author']) }}">{{ $post['author'] }}</a> in <a href="{{ URL::to('r/'.$post['subreddit']) }}">{{ $post['subreddit'] }}</a> 
					</div>
				</div>
			</div>
		</div>

		<div class="text-center">
			<a class="btn btn-primary" href="{{ URL::to('r/'.$post['subreddit']) }}">Jump back to /r/{{ $post['subreddit'] }}</a>
		</div>
	</div>
	<div class="col-md-3 visible-md visible-lg">
		@include('partials.sidebar')
	</div>
@stop