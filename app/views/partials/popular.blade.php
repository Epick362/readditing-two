@if(isset($popular) && $popular)
	<div class="panel panel-default">
		<div class="panel-heading">
			@if(Session::has('user'))
				My subreddits
			@else
				Popular subreddits
			@endif
		</div>
		<div class="panel-body">
			@foreach($popular['data']['children'] as $_sub)
				<a href="{{ URL::to('r/'.$_sub['data']['display_name']) }}">{{ $_sub['data']['display_name'] }}</a><br />
			@endforeach
		</div>
	</div>
@endif