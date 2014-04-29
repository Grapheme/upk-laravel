<?php

class Product extends BaseModel {
	
	protected $guarded = array();

	protected $table = 'products';
	
	public static $order_by = 'sort ASC,created_at DESC';
	
	public static $rules = array(
	
		'title' => 'required|between:3,255',
		'year' => 'digits:4',
		'price' => 'numeric',
		
		'seo_url' => 'alpha_dash',
		'catalog_id' => 'required|integer',
		'category_group_id' => 'required|integer'
	);
	
	public static $rules_messages = array(
	
		'title.required' => 'Название товара не должно быть пустым!',
		'title.between' => 'Название товара должно быть от 3 до 255 символов!',
		'seo_url.alpha_dash' => 'Адрес страницы товара должен содержать латинские символы, цифры, символы подчеркивания и тире',
		'catalog_id.required' => 'Номер каталога товаров должен быть определен',
		'catalog_id.integer' => 'Номер каталога товаров должен быть числом',
		'category_group_id.required' => 'Номер группы категории товаров должен быть определен',
		'category_group_id.integer' => 'Номер группы категории товаров должен быть числом',
		'year.digits' => 'Год выпуска должен быть числом и иметь 4 знака',
		'price.numeric' => 'Цена должена быть числом',
	);
	

	protected $fillable = array();
	
	
	public function catalog(){

		return $this->belongsTo('Catalog');
	}
	
	public function categoryGroup(){

		return $this->belongsTo('CategoryGroup');
	}
	
	public function user(){

		return $this->belongsTo('User');
	}
	
	public function images(){

		return $this->hasMany('Image','item_id','id');
	}
	
	public function categories(){
		
		return $this->belongsToMany('Category');
	}
}