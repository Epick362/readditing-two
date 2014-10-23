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
		ng-controller="channelController" 
		user="{{ $username or false }}" 
		channel="{{ $channel or false }}" 
	>
@overwrite

@section('nav-middle')
	<div class="col-sm-4 col-md-4">
		<form ng-submit="jumpTo()" class="navbar-form">
			<div class="input-group">
				<span class="input-group-addon">/r/</span>
				<input type="text" ng-model="sr" placeholder="{{ $channel or 'subreddit' }}" class="form-control col-sm-3 col-md-4" required>
				<div class="input-group-btn">
					<button type="submit" class="btn btn-info">Go</button>
				</div>
			</div>
		</form>
	</div>
@stop

@section('content')
	<div class="col-md-8 col-md-offset-1" style="margin-bottom:40px">
		@if(!$post['nsfw'])
			@include('partials.leaderboard')
		@endif

		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="title">{{ $post['title'] }}</span>
				<a class="pull-right" href="{{ $post['url'] }}" target="_blank" rel="nofollow">{{ $post['source'] }}</a>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body" show-more>
				{{ $post['content'] }}
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-xs-4">
						<a href="{{ URL::to('u/'.$post['author']) }}">{{ $post['author'] }}</a> in <a href="{{ URL::to('r/'.$post['subreddit']) }}">{{ $post['subreddit'] }}</a> 
					</div>
					<div class="col-xs-4 text-center">
						<a href="" ng-click="comments({{ htmlspecialchars(json_encode($post)) }})"><i class="fa fa-comment-o"></i> {{ $post['comments'] }} comments</a>
					</div>
					<div class="col-xs-4 text-right">
						{{ Carbon\Carbon::createFromTimeStamp($post['created'])->diffForHumans() }} 
					</div>
				</div>
			</div>
		</div>

		<a class="btn btn-default btn-block" href="{{ URL::to('r/'.$post['subreddit']) }}">Jump back to /r/{{ $post['subreddit'] }}</a>


		<script type="text/ng-template" id="comment.html">
			@include('partials.comment')
		</script>

		<script type="text/ng-template" id="comments.html">
			@include('partials.comments')
		</script>
	</div>
	<div class="col-md-3 visible-md visible-lg">
		@include('partials.sidebar')
	</div>
@stop