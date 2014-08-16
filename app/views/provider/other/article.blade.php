<div class="panel-text panel-text-short">
	{{ $data['readability'] }}
</div>
@if(strlen($data['readability']) > 250)
<div class="showmore-container">
	<a class="btn btn-default btn-block btn-showmore">Show More</a>
</div>
@endif