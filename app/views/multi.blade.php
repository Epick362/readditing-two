@extends('layouts.master')

@section('title')
	{{ $multi }}
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
				<input type="text" ng-model="sr" placeholder="subreddit" class="form-control col-sm-3 col-md-4" required>
				<div class="input-group-btn">
					<button type="submit" class="btn btn-primary" analytics-on analytics-event="Jump to subreddit">Go</button>
				</div>
			</div>
		</form>
	</div>
@stop

@section('content')
	<div class="col-md-8 col-md-offset-2">
		@if(!$channel || ($channel && isset($channelData['data']['over18']) && !$channelData['data']['over18']))
			@include('partials.leaderboard')
		@endif

		@include('partials.alerts')

		<div id="subreddit ng-cloak" ng-cloak>
			<div class="panel panel-default">
				<div class="panel-heading">
					{{ $multi }} 
					<span class="pull-right">{{ $subscribers }} subscribers</span>
				</div>
			</div>

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
				<a style="margin-bottom: 20px" class="btn btn-primary btn-block" href="{{ URL::to('m/'.$multi) }}">Jump back to top</a>
			@endif
			
			@include('partials.post', ['function' => "reddit.nextPage('". Input::get('after', '') ."')"])

		</div>		
	</div>
@stop