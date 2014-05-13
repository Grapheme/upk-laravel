<?php

class Rel_mod_gallery extends Eloquent {
	protected $guarded = array();

	protected $table = 'rel_mod_gallery';

    public $timestamps = false;

	public function photos() {
		return $this->hasMany('Photo', 'gallery_id', 'gallery_id');
	}
}