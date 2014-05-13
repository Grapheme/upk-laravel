<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupsTable extends Migration {

	public function up(){
		
		Schema::create('groups', function(Blueprint $table) {
			
			$table->increments('id');
			$table->string('name',20)->unique();
			$table->string('desc',20);
			$table->string('dashboard',20);
			$table->timestamps();
		});
	}

	public function down(){

		Schema::drop('groups');
	}

}
