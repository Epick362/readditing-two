@extends('layouts.master')

@section('content')
	<div id="subreddit" ng-app="subredditApp" ng-controller="subredditController" subreddit="{{ $subreddit or false }}">
		@if(Session::has('user'))
			<pre>{{ print_r(Session::get('user')) }}</pre>
		@endif

		<alert ng-repeat="alert in alerts" type="<% alert.type %>" close="closeAlert($index)"><% alert.msg %></alert>

		<!-- LOADING =============================================== -->
		<div class="loading" ng-show="loading">
			<div class="ball-outer"></div>
			<div class="ball-inner"></div>
		</div>

		@include('partials.post')
	</div>
@stop