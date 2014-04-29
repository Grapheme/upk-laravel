<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesGroupTable extends Migration {

	public function up(){
		Schema::create('categories_group', function(Blueprint $table){
			$table->increments('id');
			$table->string('title',100)->nullable();
			$table->text('description')->nullable();
			$table->string('template',100)->nullable();
			$table->string('language',10)->nullable();
			$table->boolean('publication')->default(1)->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down(){
		
		Schema::drop('categories_group');
	}

}
