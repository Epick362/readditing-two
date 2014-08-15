<div class="panel-text panel-text-short">
	{{ html_entity_decode($data['selftext_html']) }}
</div>
@if(strlen($data['selftext']) > 250)
<div class="showmore-container">
	<a class="btn btn-default btn-block btn-showmore">Show More</a>
</div>
@endif