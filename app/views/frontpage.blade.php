@extends('layouts.master')

@section('content')
	<div id="subreddit" ng-app="subredditApp" ng-controller="subredditController" subreddit="{{ $subreddit or false }}">
		@if(Session::has('user'))
			<pre>{{ print_r(Session::get('user')) }}</pre>
		@endif

		<!-- LOADING =============================================== -->
		<div class="alert alert-info" ng-show="loading">
			<i class="fa fa-refresh fa-spin"></i> Loading content
		</div>

		@include('partials.post')
	</div>
@stop