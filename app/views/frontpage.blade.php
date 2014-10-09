@extends('layouts.master')

@section('title')
	{{ $subreddit or 'frontpage' }}
@stop

@section('body')
	<body 
		ng-app="readditingApp" 
		ng-controller="subredditController" 
		user="{{ $username or false }}" 
		subreddit="{{ $subreddit or false }}" 
		subscribed="{{ $subscribed or false }}"
		nsfw="{{ Session::has('user.settings.nsfw') }}"
	>
@overwrite

@section('nav-middle')
	<div class="col-sm-4 col-md-4">
		<form ng-submit="jumpTo()" class="navbar-form">
			<div class="input-group">
				<span class="input-group-addon">/r/</span>
				<input type="text" ng-model="sr" placeholder="{{ $subreddit or 'subreddit' }}" class="form-control col-sm-3 col-md-4" required>
				<div class="input-group-btn">
					<button type="submit" class="btn btn-primary" analytics-on analytics-event="Jump to subreddit">Go</button>
				</div>
			</div>
		</form>
	</div>
@stop

@section('sidebar')
	@if(isset($subreddit) && $subreddit)
		<a class="btn btn-default btn-lg btn-block" href="{{ URL::to('submit/?subreddit='.$subreddit) }}" style="margin-bottom:10px" analytics-on>Submit new post</a>
	@else
		<a class="btn btn-default btn-lg btn-block" href="{{ URL::to('submit') }}" style="margin-bottom:10px" analytics-on>Submit new post</a>
	@endif

	<a ng-cloak class="btn btn-danger btn-block" ng-click="setNSFW()" ng-show="nsfw" href="" style="margin-bottom:10px" analytics-on analytics-category="NSFW" analytics-label="Turn off">Turn off NSFW posts</a>
@stop

@section('content')
	<div class="col-md-8 col-md-offset-1">
		@include('partials.leaderboard')

		@foreach($notifications as $notification)
			<div class="alert alert-{{ $notification['type'] }}">
				@if($notification['type'] == 'warning' || $notification['type'] == 'danger')
				<b><i class="fa fa-warning"></i> {{ ucfirst($notification['type']) }}</b><br />
				@endif
				{{ $notification['message'] }}
			</div>
		@endforeach

		<div id="subreddit ng-cloak" ng-cloak>
			@if(isset($subreddit) && $subreddit)
			<div class="panel panel-default">
				<div class="panel-heading">
					/r/{{ $subreddit }} 
					@if(Session::has('user'))
						<a href="" ng-click="subscribe(1)" ng-if="!subscribed" class="btn btn-default btn-lg pull-right"><i class="fa fa-bookmark"></i> Subscribe</a>
						<a href="" ng-click="subscribe(0)" ng-if="subscribed" class="btn btn-success btn-lg pull-right"><i class="fa fa-times"></i> Unsubscribe</a>
					@endif
				</div>
			</div>
			@endif

			<alert ng-repeat="alert in alerts" type="<% alert.type %>" close="closeAlert($index)"><% alert.msg %></alert>

			<script type="text/ng-template" id="comment.html">
				@include('partials.comment')
			</script>

			<script type="text/ng-template" id="comments.html">
				@include('partials.comments')
			</script>

			@if(Input::has('after'))
				<a style="margin-bottom: 20px" class="btn btn-primary btn-block" href="{{ URL::to('r/'.$subreddit) }}">Jump back to top</a>
			@endif
			
			@include('partials.post', ['function' => "reddit.nextPage('". Input::get('after', '') ."')"])

		</div>		
	</div>
	<div class="col-md-3 visible-md visible-lg">
		@include('partials.sidebar')
	</div>
@stop