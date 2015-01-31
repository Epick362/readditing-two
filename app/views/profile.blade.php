@extends('layouts.master')

@section('meta-extra')
	@if($hide_from_robots)
		<meta name="robots" content="noindex,nofollow" />
	@endif
@stop

@section('title')
	{{ $user }}'s Profile
@stop

@section('body')
	<body 
		ng-controller="channelController" 
		user="{{ $username or false }}" 
		profile="{{ $user or false }}"
	>
@overwrite

@section('content')
	<div class="col-md-8 col-md-offset-2" ng-cloak>
		<p class="lead text-center" style="font-size:42px">
			{{ $user }}
			@if(!empty($user_in_db))
				<i tooltip="This user has authorized with Readditing.com" class="text-success fa fa-check"></i>
			@endif
		</p>
		<ul class="nav nav-tabs nav-justified" style="margin-bottom:20px">
			<li class="{{ Request::is('u/'.$user) ? 'active' : '' }}"><a href="{{ URL::to('u/'.$user) }}">Overview</a></li>
			<li class="{{ Request::is('u/'.$user.'/submitted') ? 'active' : '' }}"><a href="{{ URL::to('u/'.$user.'/submitted') }}">Submitted</a></li>
			<li class="{{ Request::is('u/'.$user.'/gilded') ? 'active' : '' }}"><a href="{{ URL::to('u/'.$user.'/gilded') }}">Gilded</a></li>
			@if(strtolower($user) === strtolower($username))
			<li class="{{ Request::is('u/'.$user.'/liked') ? 'active' : '' }}"><a href="{{ URL::to('u/'.$user.'/liked') }}">Liked</a></li>
			<li class="{{ Request::is('u/'.$user.'/saved') ? 'active' : '' }}"><a href="{{ URL::to('u/'.$user.'/saved') }}">Saved</a></li>
			@endif
		</ul>

		<script type="text/ng-template" id="comment.html">
			@include('partials.comment')
		</script>

		<script type="text/ng-template" id="comments.html">
			@include('partials.comments')
		</script>

		@if(Input::has('after'))
			<a style="margin-bottom: 20px" class="btn btn-primary btn-block" href="{{ URL::to('u/'.$user.'/'.$category) }}">Jump back to top</a>
		@endif

		@include('partials.post', ['function' => "reddit.nextProfilePage('". $category ."', '". Input::get('after', '') ."')"])
    </div>
@stop