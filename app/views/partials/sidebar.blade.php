
<div class="col-md-2" style="position:fixed; top:120px">
	@if(isset($popular) && $popular)
		<div class="sidebar panel panel-default">
			<div class="panel-heading">
				Popular subreddits
			</div>
			<div class="panel-body">
				@foreach($popular['data']['children'] as $_sub)
					<a href="{{ URL::to('r/'.$_sub['data']['display_name']) }}">{{ $_sub['data']['display_name'] }}</a><br />
				@endforeach
			</div>
		</div>
	@endif
</div>