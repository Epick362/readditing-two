@extends('layouts.master')

@section('title')
	{{ $multi }}
@stop

@section('body')
	<body 
		ng-controller="channelController" 
		user="{{ $username or false }}" 
		channel="{{ $channel or false }}" 
		multi="{{ $multi or false }}" 
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

@section('nav-main')
	<li class="{{ Request::is('m/'.$multi) ? 'active' : '' }}"><a href="{{ URL::to('m/'.$multi) }}">Hot</a></li>
	<li class="{{ Request::is('m/'.$multi.'/rising') ? 'active' : '' }}"><a href="{{ URL::to('m/'.$multi.'/rising') }}">Rising</a></li>
	<li class="{{ Request::is('m/'.$multi.'/new') ? 'active' : '' }}"><a href="{{ URL::to('m/'.$multi.'/new') }}">New</a></li>
@stop


@section('wrap')
	<div class="channel-header" ng-cloak>
		<div class="container">
			<div class="row">
				<div class="col-md-11 col-md-offset-1">
					<h1>
						/m/{{ $multi }} <small>by <a href="{{ URL::to('u/'.$multiData['author']) }}">{{ $multiData['author'] }}</a> - {{ $subscribers }} subscribers</small>

						<span class="pull-right">
							@if(Session::has('user'))
								<a href="" ng-click="subscribe(1)" ng-if="!subscribed" class="btn btn-default btn-lg"><i class="fa fa-bookmark"></i> Subscribe</a>
								<a href="" ng-click="subscribe(0)" ng-if="subscribed" class="btn btn-success btn-lg"><i class="fa fa-times"></i> Unsubscribe</a>
							@endif
						</span>
					</h1>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-1">
				@if(!$channel || ($channel && isset($channelData['over18']) && !$channelData['over18']))
					@include('ads.leaderboard')
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
						<a style="margin-bottom: 20px" class="btn btn-primary btn-block" href="{{ URL::to('m/'.$multi) }}">Jump back to top</a>
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