<?php

class Photo extends Eloquent {
	protected $guarded = array();

	public function path() {
		return slink::path(Config::get('egg.galleries_photo_dir'))."/".$this->name;
	}
}