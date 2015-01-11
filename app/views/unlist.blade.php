@extends('layouts.master')

@section('title')
	Unlist
@stop

@section('content')
	<div class="col-md-8 col-md-offset-2">
		<h1 style="margin-top:0">Unlist from Readditing</h1>
		<hr />
		<p class="lead">
			At Readditing we strongly value privacy and thus we decided to provide a feature where a user can <strong>unlist</strong> from Readditing. After unlisting, your profile and all of your posts will not be accessible through Readditing. This also means that your username <strong>will not</strong> show up in search engines.
	    </p>
    </div>
	<div class="col-md-10 col-md-offset-1" style="margin-top:20px;">
    	{{ Form::open(array('action' => 'ProfileController@unlist')) }}
			<div class="form-group text-center">
				{{ Form::submit('Unlist '.Session::get('user.name').'!', ['class' => 'btn btn-default btn-lg']); }}
			</div>
		{{ Form::close() }}
	</div>
@stop