@extends('layouts.master')

@section('content')
	<div class="col-md-8 col-md-offset-2">
		<p class="lead text-center" style="font-size:42px">There was a <strong>server error</strong> while processing your request. This is not your fault and it would be a good idea to contact the me at {{ HTML::mailto('admin@readditing.com') }}.</p>
		<br />
		<div class="embed-responsive embed-responsive-16by9 hidden-xs">
			<iframe class="embed-responsive-item" width="560" height="315" src="//www.youtube-nocookie.com/embed/aBK9O5nDJlM" frameborder="0"></iframe>
		</div>
		<br />
    </div>
@stop