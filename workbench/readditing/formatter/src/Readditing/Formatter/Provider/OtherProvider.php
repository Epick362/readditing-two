<?php

namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;
use Readditing\Readability\Readability as Readability;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class OtherProvider extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'OtherProvider';

	public function __construct($data) {
		$this->data = $data;

		$purl = parse_url($this->data['data']['url']);

		$this->host = preg_replace('/^www\./i', '', $purl['host']);
	}

	/**
	 * This is where the magic happens
	 *
	 * @return  Array
	 */
	public function getPost()
	{
		$images = array('png', 'jpg', 'jpeg', 'gif');
		$after_dot = substr($this->data['data']['url'], strrpos($this->data['data']['url'], '.') + 1);

		if(in_array($after_dot, $images)) {
			return array(
				'title' => $this->data['data']['title'], 
				'content' => \View::make('provider.other.image', $this->data)->render(), 
				'source' => $this->host
			);
		}

		if($after_dot === 'pdf') {
			return array(
				'title' => $this->data['data']['title'], 
				'content' => \View::make('provider.other.pdf', $this->data)->render(), 
				'source' => $this->host
			);
		}

		$saved_article = \Article::where('url', $this->data['data']['url'])->first();
		if(!$saved_article) {
			$readability = new Readability($this->data['data']['url']);
			$success = $readability->init();

			if($success) {
				$this->data['data']['readability'] = $readability->getContent()->innerHTML;
			}else{
				$this->data['data']['readability'] = '';
			}

			\Article::saveArticle($this->data['data']['url'], array('content' => $this->data['data']['readability']), 0);
		}else{
			$article = $saved_article;
			$saved_article->touch();

			$this->data['data']['readability'] = $article->content;
		}

		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.other.article', $this->data)->render(), 
			'source' => $this->host
		);
	}
}
