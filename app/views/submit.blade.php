@extends('layouts.master')

@section('title')
	Submit
@stop

@section('body')
	<body 
		ng-controller="channelController" 
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
						<form ng-submit="submit(post, 'self')" role="form" style="margin-top:10px">
							<div class="form-group">
								<label>Title</label>
								<input ng-model="post.title" type="text" class="form-control">
							</div>
							<div class="form-group">
								<label>Subreddit</label>
								<input ng-model="post.sr" type="text" class="form-control" ng-init="post.sr='{{ $channel or '' }}'">
							</div>
							<div class="form-group">
								<label>Text <span class="text-muted">(optional)</span></label>
								<textarea ng-model="post.text" type="text" class="form-control" rows="6"></textarea>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary" analytics-on analytics-event="Submit - send">Send</button>
							</div>
						</form>
					</tab>
					<tab heading="Link">
						<form ng-submit="submit(post, 'link')" role="form" style="margin-top:10px">
							<div class="form-group">
								<label>Title</label>
								<input ng-model="post.title" type="text" class="form-control">
							</div>
							<div class="form-group">
								<label>Subreddit</label>
								<input ng-model="post.sr" type="text" class="form-control" ng-init="post.sr='{{ $channel or '' }}'">
							</div>
							<div class="form-group">
								<label>URL</label>
								<input ng-model="post.url" type="text" class="form-control">
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary" analytics-on analytics-event="Submit - send">Send</button>
							</div>
						</form>
					</tab>
				</tabset>
			</div>
		</div>
	</div>
@stop