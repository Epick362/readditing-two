@extends('layouts.master')

@section('title')
	{{ $channel or 'frontpage' }}
@stop

@section('body')
	<body 
		ng-controller="channelController" 
		user="{{ $username or false }}" 
		channel="{{ $channel or false }}" 
		sort="{{ $sort or false }}" 
		subscribed="{{ $subscribed or false }}"
		nsfw="{{ Session::has('user.settings.nsfw') }}"
	>
@overwrite

@section('nav-middle')
	<div class="col-sm-4 col-md-4">
		<form ng-submit="jumpTo()" class="navbar-form">
			<div class="input-group">
				<span class="input-group-addon">/r/</span>
				<input type="text" ng-model="sr" placeholder="{{ $channel or 'subreddit' }}" class="form-control col-sm-3 col-md-4" required>
				<div class="input-group-btn">
					<button type="submit" class="btn btn-info" analytics-on analytics-event="Jump to subreddit">Go</button>
				</div>
			</div>
		</form>
	</div>
@stop

@section('sidebar')
	@if(isset($channel) && $channel)
		<a class="btn btn-default btn-lg btn-block" href="{{ URL::to('submit/?channel='.$channel) }}" style="margin-bottom:10px" analytics-on>Submit new post</a>
	@else
		<a class="btn btn-default btn-lg btn-block" href="{{ URL::to('submit') }}" style="margin-bottom:10px" analytics-on>Submit new post</a>
	@endif

	<a ng-cloak class="btn btn-danger btn-block" ng-click="setNSFW()" ng-show="nsfw" href="" style="margin-bottom:10px" analytics-on analytics-category="NSFW" analytics-label="Turn off">Turn off NSFW posts</a>
@stop

@section('content')
	<div class="col-md-8 col-md-offset-1">
		@if(!$channel)
		<div id="extension" class="panel panel-primary" style="display:none;">
			<div class="panel-body">
				Install our <b><a href="" onclick="chrome.webstore.install()">Chrome extension</a></b> to automatically change reddit.com links to our site.
			</div>
		</div>
		@endif

		@if(!$channel || ($channel && isset($channelData['data']['over18']) && !$channelData['data']['over18']))
			@include('partials.leaderboard')
		@endif

		@include('partials.alerts')

		<div id="subreddit ng-cloak" ng-cloak>
			@if(isset($channel) && $channel)
			<div class="panel panel-default">
				<div class="panel-heading">
					/r/{{ $channel }} 
					@if(Session::has('user'))
						<a href="" ng-click="subscribe(1)" ng-if="!subscribed" class="btn btn-default btn-lg pull-right"><i class="fa fa-bookmark"></i> Subscribe</a>
						<a href="" ng-click="subscribe(0)" ng-if="subscribed" class="btn btn-success btn-lg pull-right"><i class="fa fa-times"></i> Unsubscribe</a>
					@endif
				</div>
			</div>
			@endif

			<script type="text/ng-template" id="comment.html">
				@include('partials.comment')
			</script>

			<script type="text/ng-template" id="comments.html">
				@include('partials.comments')
			</script>

			<script type="text/ng-template" id="comments_modal.html">
				@include('partials.comments_modal')
			</script>

			@if(Input::has('after') && Input::get('after') !== 'undefined')
				<a style="margin-bottom: 20px" class="btn btn-primary btn-block" href="{{ URL::to('r/'.$channel) }}">Jump back to top</a>
			@endif
			
			@include('partials.post', ['function' => "reddit.nextPage('". Input::get('after', '') ."')"])

		</div>		
	</div>
	<div class="col-md-3 visible-md visible-lg">
		@include('partials.sidebar')
	</div>
@stop