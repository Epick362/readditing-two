@extends('layouts.master')

@section('content')

	@if(Session::has('user'))
		<pre>{{ print_r(Session::get('user')) }}</pre>
	@endif

	@foreach($posts as $post)
	<div class="panel panel-default" data-extra="{{ $post['extra'] or '' }}">
		<div class="panel-heading">
			{{ $post['title'] }}
			<a class="pull-right" href="#">youtube.com</a>
			<div class="clearfix"></div>
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
			<div class="row">
				<div class="col-sm-4">
				@if(Session::has('user'))
					<a href="#" class="btn-postAction" data-toggle="tooltip" data-action="save" title="Save"><i class="icon-disk"></i></a>
					<a href="#" class="btn-postAction" data-toggle="tooltip" data-action="report" title="Report"><i class="icon-warning"></i></a>
					<a href="#" class="btn-postAction" data-toggle="tooltip" data-action="hide" title="Hide"><i class="icon-eye-blocked"></i></a>
				@endif
				</div>
				<div class="col-sm-4 text-center">
					<a href="#" class="btn-showcomments"><i class="icon-bubbles"></i> 0 comments</a>
				</div>
				<div class="col-sm-4 text-right">
					<a href="#" data-toggle="tooltip" data-placement="top" title="Tweet this"><i class="icon-twitter"></i></a>
					<a href="#" data-toggle="tooltip" data-placement="top" title="+ this"><i class="icon-googleplus"></i></a>
					<a href="#" data-toggle="tooltip" data-placement="top" title="Like this"><i class="icon-facebook"></i></a>					
				</div>
			</div>
		</div>	
		<?= View::make('partials.modal')->with('post', $post); ?>
	</div>
	@endforeach
	<div class="panel panel-default">
		<div class="panel-heading">
			Image
			<a class="pull-right" href="#">youtube.com</a>
		</div>
		<div class="panel-body">
			<div class="media media-nsfw">
				<img class="media-image" src="https://farm8.staticflickr.com/7457/8991328288_57b5f2a652_n.jpg" />
				<div class="media-overlay">
					<h1 class="media-overlay-title">NSFW</h1>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<a href="#">save</a>
			<a href="#">report</a>

			<a href="#" class="btn btn-default btn-xs pull-right">0 comments</a>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			Bootstrap starter template and I'm just writing some random text now to see if it will break correctly
			<a class="pull-right" href="#">youtube.com</a>
		</div>
		<div class="panel-body">
			<div class="embed">
				<div class="embed-container">
					<iframe width="560" height="315" src="//www.youtube.com/embed/PLuPJlLja7w?rel=0" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<a href="#">save</a>
			<a href="#">report</a>

			<a href="#" class="btn btn-default btn-xs pull-right">0 comments</a>
		</div>
	</div>
@stop