<?php

class ProductsAttributesTableSeeder extends Seeder{

	public function run(){
		
		Products_attributes_groups::create(array(
			'title' => 'Метал'
		));
		Products_attributes_groups::create(array(
			'title' => 'Качество'
		));
		
		Products_attributes::create(array(
			'product_attribute_group_id' => 1,
			'sort' => 1,
			'title' => 'Биллон',
			'description' => '',
			'value' => 0,
			'publication' => 1,
		));
		Products_attributes::create(array(
			'product_attribute_group_id' => 1,
			'sort' => 2,
			'title' => 'Бронза',
			'description' => '',
			'value' => 0,
			'publication' => 1,
		));
		Products_attributes::create(array(
			'product_attribute_group_id' => 1,
			'sort' => 3,
			'title' => 'Золото',
			'description' => '',
			'value' => 0,
			'publication' => 1,
		));
		Products_attributes::create(array(
			'product_attribute_group_id' => 1,
			'sort' => 4,
			'title' => 'Латунь',
			'description' => '',
			'value' => 0,
			'publication' => 1,
		));
		Products_attributes::create(array(
			'product_attribute_group_id' => 1,
			'sort' => 5,
			'title' => 'Медь',
			'description' => '',
			'value' => 0,
			'publication' => 1,
		));
		Products_attributes::create(array(
			'product_attribute_group_id' => 1,
			'sort' => 6,
			'title' => 'Потин',
			'description' => '',
			'value' => 0,
			'publication' => 1,
		));
		Products_attributes::create(array(
			'product_attribute_group_id' => 1,
			'sort' => 7,
			'title' => 'Серебро',
			'description' => '',
			'value' => 0,
			'publication' => 1,
		));
		
		products_attributes::create(array(
			'product_attribute_group_id' => 2,
			'sort' => 1,
			'title' => 'Пруф',
			'description' => '',
			'value' => 0,
			'publication' => 1,
		));
	}

}