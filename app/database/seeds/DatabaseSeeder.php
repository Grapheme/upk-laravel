<?php

class DatabaseSeeder extends Seeder {

	public function run(){
		Eloquent::unguard();
		
		$this->call('UserTableSeeder');
		$this->call('GroupsTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('ModulesTableSeeder');
		$this->call('PermissionsTableSeeder');
		$this->call('TemplatesSeeder');
		$this->call('TablesSeeder');
		$this->call('ProductsAttributesTableSeeder');
	}

}