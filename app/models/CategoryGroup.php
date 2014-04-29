<?php

class CategoryGroup extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'categories_group';

	public static $rules = array(
	
		'title' => 'required'
	);

	protected $fillable = array();
	
	public function categories(){

		return $this->hasMany('Category');

	}
	
	public function products(){

		return $this->hasMany('Product');

	}
}