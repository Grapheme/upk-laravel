<?php

class GroupsTableSeeder extends Seeder{

	public function run(){
		
		#DB::table('groups')->truncate();
		Group::create(array(
			'name' => 'admin',
			'desc' => 'Администраторы',
			'dashboard' => 'admin'
		));
		Group::create(array(
			'name' => 'user',
			'desc' => 'Пользователи',
			'dashboard' => Config::get('app-default.secure_page_link')
		));
		Group::create(array(
			'name' => 'moderator',
			'desc' => 'Модераторы',
			'dashboard' => 'moderator'
		));
	}
}