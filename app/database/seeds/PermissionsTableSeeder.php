<?php

class PermissionsTableSeeder extends Seeder{

	public function run(){
		
		Permission::create(array(
			'name' => 'create',
			'desc' => 'Создание',
			'default' => 1,
		));
		Permission::create(array(
			'name' => 'edit',
			'desc' => 'Редактирование',
			'default' => 1,
		));
		Permission::create(array(
			'name' => 'delete',
			'desc' => 'Удаление',
			'default' => 1,
		));
		Permission::create(array(
			'name' => 'publication',
			'desc' => 'Публикация',
			'default' => 1,
		));
		Permission::create(array(
			'name' => 'download',
			'desc' => 'Загрузка',
			'default' => 1,
		));
		Permission::create(array(
			'name' => 'sort',
			'desc' => 'Сортировка',
			'default' => 1,
		));
		
	}
}