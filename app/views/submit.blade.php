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
		<div class="panel panel-default">
			<form role="form">
				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" id="title" placeholder="Title">
				</div>
				@if(Input::get('subreddit'))
				<div class="form-group">
					<label for="subreddit">Subreddit</label>
					<input type="text" class="form-control" id="subreddit" placeholder="Subreddit">
				</div>
				@endif
				<div class="form-group">
					<label for="text">Text</label>
					<textarea type="text" class="form-control" id="text" placeholder="Text"></textarea>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary" >Send</button>
				</div>
			</form>
		</div>
	</div>
@stop