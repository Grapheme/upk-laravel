<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	public function up(){
		Schema::create('categories', function(Blueprint $table){
			$table->increments('id');
			$table->integer('category_group_id')->unsigned()->default(0)->index();
			$table->integer('category_parent_id')->unsigned()->nullable()->default(0);
			
			$table->integer('sort')->default(0)->unsigned()->nullable();
			$table->string('title',100)->nullable();
			$table->text('description')->nullable();
			$table->string('logo',100)->nullable();
			
			$table->string('seo_url',255)->nullable();
			$table->string('seo_title',255)->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->string('seo_h1')->nullable();
			
			$table->boolean('publication')->default(1)->unsigned()->nullable();
			$table->timestamps();
			
			$table->foreign('category_group_id')->references('id')->on('categories_group')->onDelete('cascade');
		});
	}

	public function down(){
		
		Schema::drop('categories');
	}

}
