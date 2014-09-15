@extends('layouts.master')

@section('content')
	<div id="subreddit" ng-app="subredditApp" ng-controller="subredditController" subreddit="{{ $subreddit or false }}" subscribed="{{ $subscribed or false }}">
		@if(isset($subreddit) && $subreddit)
		<div class="panel panel-default">
			<div class="panel-heading">
				/r/{{ $subreddit }} 
				@if(Session::has('user'))
					<a href="" ng-click="subscribe(1)" ng-if="!subscribed" class="btn btn-default btn-lg pull-right"><i class="fa fa-bookmark"></i> Subscribe</a>
					<a href="" ng-click="subscribe(0)" ng-if="subscribed" class="btn btn-default btn-lg pull-right active"><i class="fa fa-times"></i> Unsubscribe</a>
				@endif
			</div>
		</div>
		@endif

		@if(Session::has('user'))
			<h1>User Data</h1>
			<pre>{{ print_r(Session::get('user'), true) }}</pre>
		@endif

		@if(Session::has('access_token'))
			<h1>Access Token</h1>
			<pre>{{ print_r(Session::get('access_token'), true) }}</pre>
		@endif

		<alert ng-repeat="alert in alerts" type="<% alert.type %>" close="closeAlert($index)"><% alert.msg %></alert>

		<script type="text/ng-template" id="comment.html">
			@include('partials.comment')
		</script>

		<script type="text/ng-template" id="comments.html">
			@include('partials.comments')
		</script>

		@include('partials.post')

	</div>
@stop