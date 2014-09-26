@extends('layouts.master')

@section('body')
	<body 
		ng-app="subredditApp" 
		ng-controller="subredditController" 
		user="{{ $username or false }}" 
		profile="{{ $user or false }}"
	>
@overwrite

@section('content')
	<div class="col-md-8 col-md-offset-2" ng-cloak>
		<ul class="nav nav-tabs nav-justified" style="margin-bottom:10px">
			<li><strong>{{ $user }}</strong></li>
			<li class="{{ Request::is($user.'/') ? 'active' : '' }}"><a href="{{ URL::to('u/'.$user) }}">Overview</a></li>
			<li class="{{ Request::is($user.'/saved') ? 'active' : '' }}"><a href="{{ URL::to('u/'.$user.'/saved') }}">Saved</a></li>
			<li class="{{ Request::is($user.'/submitted') ? 'active' : '' }}"><a href="{{ URL::to('u/'.$user.'/submitted') }}">Submitted</a></li>
			<li class="{{ Request::is($user.'/gilded') ? 'active' : '' }}"><a href="{{ URL::to('u/'.$user.'/gilded') }}">Gilded</a></li>
		</ul>

		<script type="text/ng-template" id="comment.html">
			@include('partials.comment')
		</script>

		<script type="text/ng-template" id="comments.html">
			@include('partials.comments')
		</script>

		@include('partials.post', ['function' => "reddit.nextProfilePage('". $category ."', '". Input::get('after', '') ."')"])
    </div>
@stop