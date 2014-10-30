<?php
class ImgurGalleryCache extends \Eloquent {

	protected $table = 'imgur_gallery';

	public function getImagesAttribute($value) {
		return unserialize($value);
	}

	public function setImagesAttribute($value) {
		$this->attributes['images'] = serialize($value);
	}
}