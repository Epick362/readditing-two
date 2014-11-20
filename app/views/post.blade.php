@extends('layouts.master')

@section('title')
	{{ $post['title'] }} by {{ $post['author'] }}
@stop

@section('og')
	<!-- Open Graph data -->
	<meta property="og:site_name" content="getAmused.net" />
	<meta property="og:locale" content="en_GB" />
	<meta property="og:title" content="{{ htmlentities($post['title']) }}" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="{{ Request::url() }}" />
	<meta property="og:image" content="{{ URL::to('apple-touch-icon-120x120.png') }}" />
	<meta property="og:description" content="{{ $post['title'] }}" />
@overwrite

@section('meta-desc')
	{{ $post['title'] }}
@overwrite

@section('body')
	<body 
		ng-controller="channelController" 
		user="{{ $username or false }}" 
		channel="{{ $channel or false }}" 
	>
@overwrite

@section('content')
	<div class="col-md-8 col-md-offset-2" style="margin-bottom:40px">
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
					<div class="col-xs-offset-4 col-xs-4 text-right">
						{{ Carbon\Carbon::createFromTimeStamp($post['created'])->diffForHumans() }} 
					</div>
				</div>
			</div>
		</div>

		@if(!$post['nsfw'])
			@include('partials.leaderboard')
		@endif

		<div class="panel panel-default" id="comments">
			<div class="panel-heading">
				Comments
				<span class="pull-right">
					Share to: 
					<a 
						class="btn btn-share facebook" 
						analytics-on analytics-event="Share" analytics-category="Facebook" 
						href="http://www.facebook.com/sharer/sharer.php?u={{ URL::to('r') }}/<% post.subreddit %>/comments/<% post.id %>&title=<% post.title %>" 
						onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"
					>
						<i class="fa fa-facebook-square"></i> Facebook
					</a> 

					<a 
						class="btn btn-share twitter" 
						analytics-on analytics-event="Share" analytics-category="Twitter" 
						href="http://twitter.com/home?status=<% post.title %>+{{ URL::to('r') }}/<% post.subreddit %>/comments/<% post.id %>" 
						onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"
					>
						<i class="fa fa-twitter"></i> Twitter
					</a>				
				</span>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body" ng-include="'comments.html'" ng-init="post = {{ htmlspecialchars(json_encode($post)) }}"></div>
		</div>

		<script type="text/ng-template" id="comment.html">
			@include('partials.comment')
		</script>

		<script type="text/ng-template" id="comments.html">
			@include('partials.comments')
		</script>
	</div>
@stop