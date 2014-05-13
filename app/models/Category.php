<?php

class Category extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'categories';

	public static $rules = array(
	
		'title' => 'required',
		'seo_url' => 'alpha_dash',
		'category_group_id' => 'required|integer',
		'category_parent_id' => 'required|integer'
	);

	protected $fillable = array();
	
	
	public function categoryGroup(){

		return $this->belongsTo('CategoryGroup');

	}
}