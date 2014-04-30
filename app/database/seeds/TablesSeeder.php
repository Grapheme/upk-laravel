<?php

class TablesSeeder extends Seeder{

	public function run(){
		
		#DB::table('group_role')->truncate();
		#DB::table('group_user')->truncate();
		#DB::table('modules')->truncate();
		#DB::table('permissions')->truncate();
		
		#DB::table('templates')->truncate();
		#DB::table('languages')->truncate();
		#DB::table('languages')->truncate();
		
		#DB::table('products_attributes_group')->truncate();
		#DB::table('products_attributes')->truncate();
		
		Language::create(array(
			'code' => 'ru',
			'name' => 'Русский',
			'default' => 1,
		));
		#DB::table('settings')->truncate();
		Settings::create(array(
			'id' => 1,
			'name' => 'language',
			'value' => 'ru',
		));
		
		$admin = User::find(1);
		$admin->groups()->attach(1);
		$admin = User::find(2);
		$admin->groups()->attach(2);
		
		//Роли для группы Администраторы
		$group = Group::find(1);
		foreach(Role::all() as $role):
			$group->roles()->attach($role->id);
		endforeach;
		//Роли для группы Пользователи
		$group = Group::find(2);
		if($role = Role::where('name','downloads')->first()):
			$group->roles()->attach($role->id);
		endif;
		if($role = Role::where('name','galleries')->first()):
			$group->roles()->attach($role->id);
		endif;
		//Роли для группы Модераторы
		$group = Group::find(3);
		if($role = Role::where('name','pages')->first()):
			$group->roles()->attach($role->id);
		endif;
		if($role = Role::where('name','news')->first()):
			$group->roles()->attach($role->id);
		endif;
		if($role = Role::where('name','articles')->first()):
			$group->roles()->attach($role->id);
		endif;
		if($role = Role::where('name','downloads')->first()):
			$group->roles()->attach($role->id);
		endif;
		if($role = Role::where('name','galleries')->first()):
			$group->roles()->attach($role->id);
		endif;
		if($role = Role::where('name','i18n_news')->first()):
			$group->roles()->attach($role->id);
		endif;
	}
}