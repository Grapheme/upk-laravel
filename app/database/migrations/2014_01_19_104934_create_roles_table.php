<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration {

	public function up(){
		Schema::create('roles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('desc');
			$table->timestamps();
		});
	}

	public function down(){

		Schema::drop('roles');
	}

}
