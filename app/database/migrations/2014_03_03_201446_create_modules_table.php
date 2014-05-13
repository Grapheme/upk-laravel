<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModulesTable extends Migration {

	public function up(){
		Schema::create('modules', function(Blueprint $table) {
			$table->increments('id');
			$table->string('url')->nullable();
			$table->boolean('on')->default(0);
			$table->string('permissions',255)->default('[]')->nullable();
			$table->timestamps();
		});
	}

	public function down(){
		Schema::drop('modules');
	}

}