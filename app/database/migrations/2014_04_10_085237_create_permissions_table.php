<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration {

	public function up(){
		Schema::create('permissions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name',50);
			$table->string('desc',50);
			$table->boolean('default')->default(1);
			$table->timestamps();
		});
	}

	public function down(){

		Schema::drop('permissions');
	}
	
}
