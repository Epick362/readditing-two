@if($announcement)
<div class="panel panel-default notification">
	<div class="panel-body">
		<a href="{{ URL::to('r/readditingcom/comments/'. $announcement['id']) }}">
			New Readditing Announcement ("{{ $announcement['title'] }}")
			<span class="pull-right">
				Read more <i class="fa fa-angle-double-right"></i>
			</span>
		</a>
	</div>
</div>
@endif