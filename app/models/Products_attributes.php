<?php

class Products_attributes extends \BaseModel {

	protected $table = 'products_attributes';
	
	public $timestamps = false;
	
	public function productAttrGroup(){

		return $this->belongsTo('Products_attributes_groups');
	}
}