<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up(){
		
		Schema::create('products', function(Blueprint $table){
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->index();
			$table->integer('catalog_id')->unsigned()->default(0)->index();
			$table->integer('category_group_id')->unsigned()->default(0)->index();
			
			$table->integer('sort')->default(0)->unsigned()->nullable();
			$table->string('title',100)->nullable();
			$table->text('description')->nullable();
			$table->text('image')->nullable();
			$table->string('price',100)->nullable();
			
			$table->text('attributes')->nullable();
			$table->string('tags',255)->nullable();
			
			$table->string('seo_url',255)->nullable();
			$table->string('seo_title',255)->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->string('seo_h1')->nullable();
			$table->boolean('publication')->default(1)->unsigned()->nullable();
			$table->string('template',100)->nullable();
			$table->string('language',10)->nullable();
			$table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('cascade');
			$table->foreign('category_group_id')->references('id')->on('categories_group')->onDelete('cascade');
		});
	}

	public function down(){
		Schema::drop('products');
	}

}
