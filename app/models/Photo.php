<?php

class Photo extends Eloquent {
	protected $guarded = array();

	public function path() {
		#return slink::path(Config::get('app-default.galleries_photo_dir'))."/".$this->name;
		return Config::get('app-default.galleries_photo_dir') . "/" . $this->name;
	}

	public function thumb() {
		return slink::path(Config::get('app-default.galleries_thumb_dir'))."/".$this->name;
	}
}