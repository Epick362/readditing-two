<?php
namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Exception\ClientException;


class Imgur extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'imgur';

	public function __construct($data) {
		$this->data = $data;
	}
	/**
	 * This is where the magic happens
	 *
	 * @return  Array
	 */
	public function getPost()
	{
		$parsed_url = parse_url($this->data['data']['url']);

		$images = array('png', 'jpg', 'jpeg', 'gif');
		$after_dot = substr($parsed_url['path'], strrpos($parsed_url['path'], '.') + 1);

		if(!in_array($after_dot, $images)) {
			$parts = explode('/', $parsed_url['path']);

			if($parts[1] == 'a') {
				return $this->getAlbum();
			}else if($parts[1] == 'gallery') {
				return $this->getGallery($parts[2]);
			}else{
				return $this->getImage($parts[1]);
			}
		}

		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.other.image', $this->data)->render(), 
			'source' => 'imgur.com'
		);
	}

	public function getAlbum() {
		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.imgur', $this->data)->render(), 
			'source' => 'imgur.com'
		);
	}

	public function getGallery($id) {
		$cache = \ImgurGalleryCache::where('name', $id)->first();
dd($id);
		if($cache) {
			$this->data['data']['images'] = $cache['images'];

			$cache->touch();
		}else if(!\Cache::has('imgurRateLimit')) {
			try {
				$client = new Client();
				$imgur = $client->get("https://api.imgur.com/3/gallery/".$id, [
					'headers' => ['Authorization' => 'Client-ID 45bdae835f9d9d6']
				]);

				$response = $imgur->json();
			}catch (\Exception $e) {
				return $this->fail();
			}

			if($imgur->getStatusCode() == 429 || ($imgur->getHeader('X-RateLimit-ClientRemaining') && $imgur->getHeader('X-RateLimit-ClientRemaining') < 50)) {
				\Cache::put('imgurRateLimit', 'now', 120);
			}

			foreach($response['data']['images'] as $_image) {
				$images[] = $_image['link'];

				$image = new \ImgurCache;
				$image['name'] = $_image['id'];
				$image['link'] = $_image['link'];
				$image->save();
			}

			$gallery = new \ImgurCache;
			$gallery['name'] = $id;
			$gallery['images'] = $images;
			$gallery->save();

			$this->data['data']['images'] = $images;
		}else{
			return $this->fail();
		}

		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.other.images', $this->data)->render(), 
			'source' => 'imgur.com'
		);
	}

	public function getImage($id) {
		$cache = \ImgurCache::where('name', $id)->first();

		if($cache) {
			$this->data['data']['url'] = $cache['link'];

			$cache->touch();
		}else if(!\Cache::has('imgurRateLimit')) {
			try {
				$client = new Client();
				$imgur = $client->get("https://api.imgur.com/3/image/".$id, [
					'headers' => ['Authorization' => 'Client-ID '. \Config::get('oauth.imgur.client_id')]
				]);

				$response = $imgur->json();
			}catch (\Exception $e) {
				return $this->fail();
			}

			if($imgur->getStatusCode() == 429 || ($imgur->getHeader('X-RateLimit-ClientRemaining') && $imgur->getHeader('X-RateLimit-ClientRemaining') < 50)) {
				\Cache::put('imgurRateLimit', 'now', 120);
			}

			$image = new \ImgurCache;
			$image['name'] = $id;
			$image['link'] = $response['data']['link'];
			$image->save();

			$this->data['data']['url'] = $response['data']['link'];
		}else{
			return $this->fail();
		}

		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.other.image', $this->data)->render(), 
			'source' => 'imgur.com'
		);
	}

	private function fail() {
		return array(
			'title' => $this->data['data']['title'], 
			'content' => 'Sorry we couldn\'t get this image for you', 
			'source' => 'imgur.com'
		);
	}
}
