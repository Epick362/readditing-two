@extends('layouts.master')

@section('title')
	Login
@stop

@section('content')
	<div class="col-md-6 col-md-offset-3">
		<h1 style="margin-top:0">Login</h1>
		<hr />
		<p class="lead">
			Logging in will enable you to <b>comment</b>, <b>upvote</b> posts, <b>submit</b> new ones and <b>save</b> content you like for later!
	    </p>

		<div class="text-center" style="margin:20px">
			<a class="btn btn-default btn-lg" href="{{ URL::to('auth/login') }}" analytics-on analytics-event="Login">Login with Reddit</a>
		</div>

		<p>
			Readditing enables you to <b>securely</b> log in to your reddit account without you having to provide your login credentials on our site. Click the button above to begin.
	    </p>
    </div>
@stop