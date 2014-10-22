@extends('layouts.master')

@section('title')
	the happiest place on the internet
@stop

@section('body')
	<body 
		ng-app="readditingApp" 
		ng-controller="channelController" 
		user="{{ $username or false }}" 
		channel="{{ $channel or false }}" 
		subscribed="{{ $subscribed or false }}"
		nsfw="{{ Session::has('user.settings.nsfw') }}"
	>
@overwrite

@section('sidebar')
	@if(isset($channel) && $channel)
		<a class="btn btn-default btn-lg btn-block" href="{{ URL::to('submit/?channel='.$channel) }}" style="margin-bottom:10px" analytics-on>Submit new post</a>
	@else
		<a class="btn btn-default btn-lg btn-block" href="{{ URL::to('submit') }}" style="margin-bottom:10px" analytics-on>Submit new post</a>
	@endif

	<a ng-cloak class="btn btn-danger btn-block" ng-click="setNSFW()" ng-show="nsfw" href="" style="margin-bottom:10px" analytics-on analytics-category="NSFW" analytics-label="Turn off">Turn off NSFW posts</a>
@stop

@section('content')
	<div class="col-md-8 col-md-offset-2">
		@if(!$channel || ($channel && isset($channelData['data']['over18']) && !$channelData['data']['over18']))
			@include('partials.leaderboard')
		@endif

		@foreach($notifications as $notification)
			<div class="alert alert-{{ $notification['type'] }}">
				@if($notification['type'] == 'warning' || $notification['type'] == 'danger')
				<b><i class="fa fa-warning"></i> {{ ucfirst($notification['type']) }}</b><br />
				@endif
				{{ $notification['message'] }}
			</div>
		@endforeach

		<div id="subreddit ng-cloak" ng-cloak>
			<script type="text/ng-template" id="comment.html">
				@include('partials.comment')
			</script>

			<script type="text/ng-template" id="comments.html">
				@include('partials.comments')
			</script>

			@if(Input::has('after') && Input::get('after') !== 'undefined')
				<a style="margin-bottom: 20px" class="btn btn-primary btn-block" href="{{ URL::to('r/'.$channel) }}">See fresh posts</a>
			@endif
			
			@include('partials.post', ['function' => "reddit.nextPage('". Input::get('after', '') ."')"])

		</div>		
	</div>
@stop