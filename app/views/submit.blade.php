@extends('layouts.master')

@section('body')
	<body 
		ng-app="subredditApp" 
		ng-controller="subredditController" 
		user="{{ $username or false }}" 
		subreddit="{{ Input::get('subreddit') or false }}" 
	>
@overwrite

@section('nav-middle')
	<div class="col-sm-4 col-md-4">
		<form ng-submit="jumpTo()" class="navbar-form">
			<div class="input-group">
				<span class="input-group-addon">/r/</span>
				<input type="text" ng-model="sr" placeholder="{{ Input::get('subreddit') or 'subreddit' }}" class="form-control col-sm-3 col-md-4" required>
				<div class="input-group-btn">
					<button type="submit" class="btn btn-primary">Go</button>
				</div>
			</div>
		</form>
	</div>
@stop

@section('content')
	<div class="col-md-8 col-md-offset-2">
		<div id="subreddit">

			Hello this is submit to {{ Input::get('subreddit') }}!

		</div>
	</div>
@stop