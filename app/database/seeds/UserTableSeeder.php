<?php

class UserTableSeeder extends Seeder{

	public function run(){
		
		DB::table('users')->truncate();
		User::create(array(
			'name'=>'Администратор',
			'surname'=>'',
			'email'=>'admin@monety.pro',
			'active'=>1,
			'password'=>Hash::make('123456'),
			'photo'=>'img/avatars/male.png',
			'thumbnail'=>'img/avatars/male.png',
			'temporary_code'=>'',
			'code_life'=>0,
		));
	}

}