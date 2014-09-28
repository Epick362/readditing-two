@extends('layouts.master')

@section('content')
	<div class="col-md-6 col-md-offset-3">
		<h1 style="margin-top:0">Login</h1>
		<hr />
		<p class="lead">
			Readditing enables you to securely log in to your reddit account without you having to provide your login credentials on our site. Click the button below to begin.

			<a class="btn btn-default btn-block btn-lg" href="{{ URL::to('auth/login') }}">Login with Reddit account</a>
	    </p>
    </div>
@stop