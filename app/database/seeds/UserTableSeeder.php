<?php

class UserTableSeeder extends Seeder{

	public function run(){
		
		DB::table('users')->truncate();
		User::create(array(
			'name'=>'Администратор',
			'surname'=>'',
			'email'=>'admin@uspensky-pk.ru',
			'active'=>1,
			'password'=>Hash::make('123456'),
			'photo'=>'img/avatars/male.png',
			'thumbnail'=>'img/avatars/male.png',
			'temporary_code'=>'',
			'code_life'=>0,
		));
		User::create(array(
			'name'=>'Пользователь',
			'surname'=>'',
			'email'=>Config::get('app-default.secure_page_link'),
			'active'=>1,
			'password'=>Hash::make('123456'),
			'photo'=>'img/avatars/male.png',
			'thumbnail'=>'img/avatars/male.png',
			'temporary_code'=>'',
			'code_life'=>0,
		));
	}

}