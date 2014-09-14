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


		<script type="text/ng-template" id="comment.html">
			<div class="media-body">
				<h4 class="media-heading"><a href="#"><% comment.author %></a> <small class="text-alternate"><i class="fa fa-arrow-up"></i> <% comment.score %></small></h4>
				<div ng-bind-html="comment.body"></div>
				@if(Session::has('user'))
				<div>
					<a class="btn btn-default btn-xs" href="#">Reply</a>
					<a class="btn btn-default btn-xs" ng-click="save(comment.id, 't1', 1)">Save</a>
					<a class="btn btn-default btn-xs" href="#">Report</a>
					<a class="btn btn-default btn-xs" href="#">Give Gold</a>
				</div>
				@endif
				<div ng-if="comment.replies.length > 0" class="media" ng-repeat="comment in comment.replies" ng-include="'comment.html'"></div>
			</div>
		</script>

		<script type="text/ng-template" id="comments.html">
			@include('partials.comments')
		</script>

		@include('partials.post')

	</div>
@stop