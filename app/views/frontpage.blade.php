@extends('layouts.master')

@section('content')
	<div id="subreddit" ng-app="subredditApp" ng-controller="subredditController" subreddit="{{ $subreddit or false }}">
		@if(Session::has('user'))
			<h1>User Data</h1>
			<pre>{{ print_r(Session::get('user')) }}</pre>
		@endif

		@if(Session::has('access_token'))
			<h1>Access Token</h1>
			<pre>{{ print_r(Session::get('access_token')) }}</pre>
		@endif

		<alert ng-repeat="alert in alerts" type="<% alert.type %>" close="closeAlert($index)"><% alert.msg %></alert>

		@include('partials.post')

	</div>
@stop