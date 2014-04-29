<?php

class Template extends Eloquent {
	
	protected $guarded = array();

	protected $table = 'templates';

	public static $rules = array(
	
		'name' => 'required'
	);

}