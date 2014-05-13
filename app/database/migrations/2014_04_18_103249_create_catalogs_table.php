<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCatalogsTable extends Migration {

	public function up(){
		Schema::create('catalogs', function(Blueprint $table){
			$table->increments('id');
			$table->string('title',100)->nullable();
			$table->text('description')->nullable();
			$table->text('fields')->nullable();
			$table->string('logo',100)->nullable();
			$table->string('template',100)->nullable();
			$table->string('language',10)->nullable();
			$table->boolean('publication')->default(1)->unsigned()->nullable();
			$table->timestamps();
		});
	}
	
	public function down(){
		
		Schema::drop('catalogs');
	}

}
