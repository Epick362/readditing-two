@extends('layouts.master')

@section('body')
	<body 
		ng-app="subredditApp" 
		ng-controller="subredditController" 
		user="{{ $username or false }}" 
		subreddit="{{ $subreddit or false }}" 
	>
@overwrite

@section('nav-middle')
	<div class="col-sm-4 col-md-4">
		<form ng-submit="jumpTo()" class="navbar-form">
			<div class="input-group">
				<span class="input-group-addon">/r/</span>
				<input type="text" ng-model="sr" placeholder="{{ $subreddit or 'subreddit' }}" class="form-control col-sm-3 col-md-4" required>
				<div class="input-group-btn">
					<button type="submit" class="btn btn-primary">Go</button>
				</div>
			</div>
		</form>
	</div>
@stop

@section('content')
	<div class="col-md-8 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				{{ $post['title'] }}
				<a class="pull-right" href="{{ $post['url'] }}" target="_blank" rel="nofollow">{{ $post['source'] }}</a>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body" show-more>
				{{ $post['content'] }}
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-4">
						<a ng-href="{{ URL::to('u/'.$post['author']) }}">{{ $post['author'] }}</a> in <a href="{{ URL::to('r/'.$post['subreddit']) }}">$post['author']</a> 
					</div>
					<div class="col-sm-4 text-center">
						<a href="" ng-click="comments({subreddit: '{{ $post['subreddit'] }}', id: 't3_{{ $post['id'] }}')"><i class="fa fa-comment-o"></i> {{ $post['comments'] }} comments</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 visible-md visible-lg">
		@include('partials.sidebar')
	</div>
@stop