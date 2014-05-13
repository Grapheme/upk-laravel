<?php

class Image extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'images';

	public static $rules = array(
		
		'module_id'=> 'required|integer',
		
	);

	protected $fillable = array();
	
	public function product(){

		return $this->belongsTo('Products','item_id','id');

	}
	
	public function module(){

		return $this->hasOne('Modules','item_id','id');

	}
	
}