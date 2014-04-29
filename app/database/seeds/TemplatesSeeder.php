<?php

class TemplatesSeeder extends Seeder{

	public function run(){
		
		Template::create(array(
			'name' => 'default',
			'static' => 1,
			'content' => '',
		));
		Template::create(array(
			'name' => 'catalog',
			'static' => 1,
			'content' => '',
		));
		Template::create(array(
			'name' => 'news',
			'static' => 1,
			'content' => '',
		));
		Template::create(array(
			'name' => 'articles',
			'static' => 1,
			'content' => '',
		));
		Template::create(array(
			'name' => 'category',
			'static' => 1,
			'content' => '',
		));
		Template::create(array(
			'name' => 'product',
			'static' => 1,
			'content' => '',
		));
		Template::create(array(
			'name' => 'manufacturer',
			'static' => 1,
			'content' => '',
		));
	}

}