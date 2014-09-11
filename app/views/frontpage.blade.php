@extends('layouts.master')

@section('content')
	<div id="subreddit" ng-app="subredditApp" ng-controller="subredditController" subreddit="{{ $subreddit or false }}">
		@if(Session::has('user'))
			<h1>User Data</h1>
			<pre>{{ print_r(Session::get('user'), true) }}</pre>
		@endif

		@if(Session::has('access_token'))
			<h1>Access Token</h1>
			<pre>{{ print_r(Session::get('access_token'), true) }}</pre>
		@endif

		<alert ng-repeat="alert in alerts" type="<% alert.type %>" close="closeAlert($index)"><% alert.msg %></alert>

		<script type="text/ng-template" id="comments.html">
	        <div class="modal-header">
	            <h3 class="modal-title">Im a modal!</h3>
	        </div>
	        <div class="modal-body">
	            <% id %>
	        </div>
	        <div class="modal-footer">
	            <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
	        </div>
	    </script>

		@include('partials.post')

	</div>
@stop