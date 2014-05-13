<?php

class Manufacturer extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'manufacturers';

	public static $rules = array(
	
		'title' => 'required',
		'seo_url' => 'alpha_dash',
	);

	protected $fillable = array();
	
}