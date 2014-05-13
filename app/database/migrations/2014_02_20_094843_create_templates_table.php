<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTemplatesTable extends Migration {

	public function up(){
		Schema::create('templates', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('content');
			$table->boolean('static')->default(0)->unsigned()->nullable();
			$table->timestamps();
		});
	}
	
	public function down(){
		Schema::drop('templates');
	}

}