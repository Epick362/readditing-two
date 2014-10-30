@foreach($data['images'] as $image)
	@include('provider.other.image', ['data' => ['subreddit' => $data['subreddit'], 'id' => $data['id'], 'url' => $image]])

	<br />
@endforeach