@extends('layouts.master')

@section('title')
	{{ $post['title'] }} by {{ $post['author'] }}
@stop

@section('og')
	<!-- Open Graph data -->
	<meta property="og:site_name" content="getAmused.net" />
	<meta property="og:locale" content="en_GB" />
	<meta property="og:title" content="{{ $post['title'] }} by {{ $post['author'] }}" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="{{ Request::url() }}" />
	<meta property="og:image" content="{{ URL::to('apple-touch-icon-120x120.png') }}" />
	<meta property="og:description" content="{{ $post['title'] }}" />
@overwrite

@section('body')
	<body 
		ng-app="readditingApp" 
		ng-controller="channelController" 
		user="{{ $username or false }}" 
		channel="{{ $channel or false }}" 
	>
@overwrite

@section('content')
	<div class="col-md-8 col-md-offset-2" style="margin-bottom:40px">
		@if(!$post['nsfw'])
			@include('partials.leaderboard')
		@endif

		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="title">{{ $post['title'] }}</span>
			</div>
			<div class="panel-body" show-more>
				{{ $post['content'] }}
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-xs-4">
						<a href="{{ URL::to('u/'.$post['author']) }}">{{ $post['author'] }}</a></a> 
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


		<script type="text/ng-template" id="comment.html">
			@include('partials.comment')
		</script>

		<script type="text/ng-template" id="comments.html">
			@include('partials.comments')
		</script>
	</div>
@stop