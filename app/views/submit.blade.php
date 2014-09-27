@extends('layouts.master')

@section('body')
	<body 
		ng-app="subredditApp" 
		ng-controller="subredditController" 
		user="{{ $username or false }}" 
	>
@overwrite

@section('nav-middle')
	<div class="col-sm-4 col-md-4">
		<form ng-submit="jumpTo()" class="navbar-form">
			<div class="input-group">
				<span class="input-group-addon">/r/</span>
				<input type="text" ng-model="sr" placeholder="subreddit" class="form-control col-sm-3 col-md-4" required>
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
			<div class="panel-heading">Submit a new post</div>
			<div class="panel-body">
				<tabset justified="true">
					<tab heading="Text">
						<form role="form" style="margin-top:10px">
							<div class="form-group">
								<label>Title</label>
								<input type="text" class="form-control">
							</div>
							@if(!Input::get('subreddit'))
							<div class="form-group">
								<label>Subreddit</label>
								<input type="text" class="form-control">
							</div>
							@endif
							<div class="form-group">
								<label>Text <span class="text-muted">(optional)</span></label>
								<textarea type="text" class="form-control" rows="6"></textarea>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary">Send</button>
							</div>
						</form>
					</tab>
					<tab heading="Link">
						<form role="form" style="margin-top:10px">
							<div class="form-group">
								<label>Title</label>
								<input type="text" class="form-control">
							</div>
							@if(!Input::get('subreddit'))
							<div class="form-group">
								<label>Subreddit</label>
								<input type="text" class="form-control">
							</div>
							@endif
							<div class="form-group">
								<label>URL</label>
								<input type="text" class="form-control">
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary">Send</button>
							</div>
						</form>
					</tab>
				</tabset>
			</div>
		</div>
	</div>
@stop