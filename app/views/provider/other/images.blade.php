@foreach($data['images'] as $image)
	@include('other.image', ['data' => ['url' => $image]])

	<br />
@endforeach