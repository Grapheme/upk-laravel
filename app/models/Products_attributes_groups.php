<?php

class Products_attributes_groups extends \BaseModel {
	
	public $timestamps = false;
	
	protected $table = 'products_attributes_group';
	
	public function productAttributes(){

		return $this->hasMany('Products_attributes','product_attribute_group_id');
	}
}