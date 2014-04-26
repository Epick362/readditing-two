@extends('layouts.master')

@section('content')

	@foreach($posts as $post)
	<div class="panel panel-default">
		<div class="panel-heading">
			{{ $post['title'] }}
			<a class="pull-right" href="#">youtube.com</a>
		</div>
		<div class="panel-body">
			<div class="panel-text panel-text-short">
				{{ $post['content'] }}
			</div>
			<div class="showmore-container">
				<a class="btn btn-default btn-block btn-showmore">Show More</a>
			</div>
		</div>
		<div class="panel-footer">
			<a href="#">save</a>
			<a href="#">report</a>

			<a href="#" class="btn btn-default btn-xs pull-right">0 comments</a>
		</div>	
		<?= View::make('partials.modal'); ?>
	</div>
	@endforeach
	<div class="panel panel-default">
		<div class="panel-heading">
			Bootstrap starter template and I'm just writing some random text now to see if it will break correctly
			<a class="pull-right" href="#">youtube.com</a>
		</div>
		<div class="panel-body">
			<div class="embed-container">
				iframe here
			</div>
		</div>
		<div class="panel-footer">
			<a href="#">save</a>
			<a href="#">report</a>

			<a href="#" class="btn btn-default btn-xs pull-right">0 comments</a>
		</div>
	</div>
@stop