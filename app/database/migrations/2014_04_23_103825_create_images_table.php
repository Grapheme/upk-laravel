<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration {


	public function up(){
		
		Schema::create('images', function(Blueprint $table){
			$table->increments('id');
			$table->integer('module_id')->unsigned()->default(0)->index();
			$table->integer('item_id')->unsigned()->default(0)->index();
			$table->integer('user_id')->unsigned()->default(0)->index();
			
			$table->integer('sort')->default(0)->unsigned()->nullable();
			$table->string('title',255)->nullable();
			$table->text('description')->nullable();
			$table->text('paths')->nullable();
			$table->text('attributes')->nullable();
			
			$table->boolean('publication')->default(1)->unsigned()->nullable();
			$table->timestamps();
			
			$table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
		});
	}

	public function down(){
		Schema::drop('images');
	}

}
