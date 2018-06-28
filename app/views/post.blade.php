@extends('layouts.master')

@section('title')
	{{ $post['title'] }} by {{ $post['author'] }}
@stop

@section('og')
	<!-- Open Graph data -->
	<meta property="og:site_name" content="Redditing.com" />
	<meta property="og:locale" content="en_GB" />
	<meta property="og:title" content="{{ htmlentities($post['title']) }}" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="{{ Request::url() }}" />
	@if(isset($post['image']))
		<meta property="og:image" content="@yield('meta-image', $post['image'])" />
	@endif
	<meta property="og:description" content="{{ str_limit(trim(preg_replace('/\s+/', ' ', htmlentities(strip_tags($post['content'])))), 150) }}" />
@overwrite

@section('meta-desc')
	{{ str_limit( trim(preg_replace('/\s+/', ' ', htmlentities(strip_tags($post['content'])))), 150) }}
@overwrite

@section('body')
	<body
		ng-controller="channelController"
		user="{{ $username or false }}"
		channel="{{ $channel or false }}"
		ng-init="post = {{ htmlspecialchars(json_encode($post)) }}"
	>
@overwrite

@section('nav-middle')
	<div class="col-sm-4 col-md-4">
		<form ng-submit="jumpTo()" class="navbar-form">
			<div class="input-group">
				<span class="input-group-addon">/r/</span>
				<input type="text" ng-model="sr" placeholder="{{ $channel or 'subreddit' }}" class="form-control col-sm-3 col-md-4" required>
				<div class="input-group-btn">
					<button type="submit" class="btn btn-jump">Go</button>
				</div>
			</div>
		</form>
	</div>
@stop

@section('content')
	<div class="col-md-8 col-md-offset-1" style="margin-bottom:40px">

		@if(!$post['nsfw'])
			@include('ads.leaderboard')
		@endif

		<div class="panel panel-default {{ ($post['nsfw'] ? 'nsfw' : '') }}">

			@include('partials.upvote_aside')

			<div class="panel-heading">
				<span class="title">{{ $post['title'] }}</span>
			</div>
			<div class="panel-body" show-more>
				{{ $post['content'] }}
			</div>

			@include('partials.upvote_inline')

			<div class="panel-footer">
				<div class="row">
					<div class="col-xs-4">
						<a href="{{ URL::to('r/'.$post['channel']) }}">/r/{{ $post['channel'] }}</a>
						by <a href="{{ URL::to('u/'.$post['author']) }}">{{ $post['author'] }}</a>
					</div>
					<div class="col-xs-4">
						{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post['created_at'])->diffForHumans() }}
					</div>
					<div class="col-xs-offset-4 col-xs-4 text-right">
						Source: <a href="{{ $post['url'] }}" target="_blank" rel="nofollow">{{ $post['source'] }}</a>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default" style="margin-top: 60px" id="comments">
			<div class="panel-heading">
				{{ $post['comments'] }} comments
			</div>
			<div class="panel-body" ng-include="'comments.html'"></div>
		</div>

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
