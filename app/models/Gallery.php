<?php

class gallery extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'name' => 'required|unique:galleries',
	);

	public function photos()
	{
		return $this->hasMany('Photo');
	}

	public static function getRules()
	{
		return self::$rules;
	}
}