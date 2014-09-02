
<div class="col-md-2" style="position:fixed; top:120px">
	@if(isset($subreddit) && $subreddit)
	<div class="sidebar panel panel-default">
		<div class="panel-body">
			<div class="panel-heading">
				{{ $subreddit }}
			</div>
			@if(Session::has('user'))
			<a href="#" class="btn btn-default btn-block"><i class="fa fa-bookmark"></i> Subscribe</a>
			@endif
		</div>
	</div>
	@endif

	@if(isset($popular) && $popular)
	<div class="sidebar panel panel-default">
		<div class="panel-heading">
			Popular subreddits
		</div>
		<div class="panel-body">
			@foreach($popular['data']['children'] as $_sub)
				<a href="{{ URL::to('r/'.$_sub['display_name']) }}">{{ $_sub['display_name'] }}</a><br />
			@endforeach
		</div>
	</div>
	@endif
</div>