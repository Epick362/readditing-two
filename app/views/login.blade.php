@extends('layouts.master')

@section('content')
	<div class="col-md-6 col-md-offset-3">
		<h1 style="margin-top:0">Login</h1>
		<hr />
		<p class="lead">
			Logging in will enable you to upvote post, submit new ones and save content you like for later!
	    </p>

		<p>
			Readditing enables you to <b>securely</b> log in to your reddit account without you having to provide your login credentials on our site. Click the button below to begin.
	    </p>

		<div class="text-center">
			<a class="btn btn-default btn-lg" href="{{ URL::to('auth/login') }}">Login with Reddit account</a>
		</div>
    </div>
@stop