@foreach($notifications as $notification)
	<div class="alert alert-{{ $notification['type'] }}">
		@if($notification['type'] == 'warning' || $notification['type'] == 'danger')
		<b><i class="fa fa-warning"></i> {{ ucfirst($notification['type']) }}</b><br />
		@endif
		{{ $notification['message'] }}
	</div>
@endforeach