@extends('layouts.master')

@section('title')
	{{ $channelData['display_name'] or 'Frontpage' }}
@stop

@if(isset($channel, $channelData['public_description']))
	@section('meta-desc')
		{{ str_limit($channelData['public_description'], 150) }}
	@stop
@endif

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

@if(isset($channel))
	@section('nav-main')
		<li class="{{ Request::is('r/'.$channel) ? 'active' : '' }}"><a href="{{ URL::to('r/'.$channel) }}">Hot</a></li>
		<li class="{{ Request::is('r/'.$channel.'/rising') ? 'active' : '' }}"><a href="{{ URL::to('r/'.$channel.'/rising') }}">Rising</a></li>
		<li class="{{ Request::is('r/'.$channel.'/new') ? 'active' : '' }}"><a href="{{ URL::to('r/'.$channel.'/new') }}">New</a></li>
	@stop
@endif

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
	<a ng-cloak class="btn btn-danger btn-block" ng-click="setNSFW()" ng-show="nsfw" href="" style="margin-bottom:20px" analytics-on analytics-category="NSFW" analytics-label="Turn off">Turn off NSFW</a>
@stop

@section('wrap')
	@if(isset($channel, $channelData['subscribers']))
	<div class="channel-header" ng-cloak>
		<div class="container">
			<div class="row">
				<div class="col-md-11 col-md-offset-1">
					<h1>
						/r/{{ $channel }} <small>{{ $channelData['subscribers'] }} subscribers</small>

						<span class="pull-right">
							@if(Session::has('user'))
								<a href="" ng-click="subscribe(1)" ng-if="!subscribed" class="btn btn-default btn-lg"><i class="fa fa-bookmark"></i> Subscribe</a>
								<a href="" ng-click="subscribe(0)" ng-if="subscribed" class="btn btn-success btn-lg"><i class="fa fa-times"></i> Unsubscribe</a>
							@endif

							<a href="{{ URL::to('submit/?channel='.$channel) }}" class="btn btn-danger btn-lg">Submit</a>
						</span>
					</h1>
				</div>
			</div>
		</div>
	</div>
	@else
	<div id="wrap"></div>
	@endif

	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-1">
				@if(!$channel || ($channel && isset($channelData['over18']) && !$channelData['over18']))
					@include('partials.leaderboard')
				@endif
				
				@include('partials.alerts')

				<div id="subreddit" ng-cloak>
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
				@include('partials.sidebar', ['channel' => $channel])
			</div>
		</div>
	</div>
@overwrite
