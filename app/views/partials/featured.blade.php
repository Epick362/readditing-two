@if(isset($featured) && $featured)
	<div class="panel panel-default">
		<div class="panel-heading">Featured</div>
		<div class="panel-body">
			@foreach($featured as $_f)
			<a class="featured" href="{{ URL::to('r/'.$_f['subreddit'].'/comments/'.$_f['id']) }}?ref=featured" target="_blank" analytics-on analytics-category="Featured" analytics-label="Goto">
				<img src="{{ $_f['image'] }}" />
				<p class="text">
					{{ $_f['title'] }}
				</p> 
			</a>
			@endforeach
		</div>
	</div>
@endif