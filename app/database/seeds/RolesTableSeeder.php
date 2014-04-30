<?php

class RolesTableSeeder extends Seeder{

	public function run(){
		
		#DB::table('roles')->truncate();
		Role::create(array(
			'name' => 'news',
			'desc' => 'Управление новостими',
		));
		Role::create(array(
			'name' => 'articles',
			'desc' => 'Управление статьями',
		));
		Role::create(array(
			'name' => 'pages',
			'desc' => 'Управление страницами',
		));
		Role::create(array(
			'name' => 'catalogs',
			'desc' => 'Управление каталогами товаров',
		));
		Role::create(array(
			'name' => 'users',
			'desc' => 'Управление пользователями',
		));
		Role::create(array(
			'name' => 'downloads',
			'desc' => 'Управление загрузками',
		));
		Role::create(array(
			'name' => 'statistic',
			'desc' => 'Управление статистикой',
		));
		Role::create(array(
			'name' => 'galleries',
			'desc' => 'Управление галереями',
		));
		Role::create(array(
			'name' => 'languages',
			'desc' => 'Управление языками',
		));
		Role::create(array(
			'name' => 'settings',
			'desc' => 'Управление настройками',
		));
		Role::create(array(
			'name' => 'templates',
			'desc' => 'Управление шаблонами',
		));

	}

}