@foreach($notifications as $notification)
	<div class="alert alert-{{ $notification['type'] }}">
		@if($notification['type'] == 'warning' || $notification['type'] == 'danger')
		<strong><i class="fa fa-warning"></i> {{ ucfirst($notification['type']) }}</strong><br />
		@endif
		{{ $notification['message'] }}
	</div>
@endforeach