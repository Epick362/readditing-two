@extends('layouts.master')

@section('content')
	<div class="col-md-8 col-md-offset-1">
		<div id="subreddit">
			@if(isset($subreddit) && $subreddit)
			<div class="panel panel-default">
				<div class="panel-heading">
					/r/{{ $subreddit }} 
					@if(Session::has('user'))
						<a href="" ng-click="subscribe(1)" ng-if="!subscribed" class="btn btn-default btn-lg pull-right"><i class="fa fa-bookmark"></i> Subscribe</a>
						<a href="" ng-click="subscribe(0)" ng-if="subscribed" class="btn btn-success btn-lg pull-right"><i class="fa fa-times"></i> Unsubscribe</a>
					@endif
				</div>
			</div>
			@endif

			<alert ng-repeat="alert in alerts" type="<% alert.type %>" close="closeAlert($index)"><% alert.msg %></alert>
			
			@include('partials.post')

		</div>		
	</div>
	<div class="col-md-3 visible-md visible-lg">
		@include('partials.sidebar')
	</div>


	<script type="text/ng-template" id="comment">
		@include('partials.comment')
	</script>

	<script type="text/ng-template" id="comments">
		@include('partials.comments')
	</script>
@stop