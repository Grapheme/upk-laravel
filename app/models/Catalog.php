<?php

class Catalog extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'catalogs';

	public static $rules = array(
	
		'title' => 'required',
	);

	protected $fillable = array();
	
	public function products(){

		return $this->hasMany('Product');

	}
}