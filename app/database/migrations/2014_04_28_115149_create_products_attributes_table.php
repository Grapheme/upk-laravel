<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsAttributesTable extends Migration {

	public function up(){
		Schema::create('products_attributes', function(Blueprint $table){
			
			$table->increments('id');
			$table->integer('sort')->default(0)->unsigned()->nullable();
			$table->integer('product_attribute_group_id')->unsigned()->default(0)->index();
			$table->string('title',100)->nullable();
			$table->text('description')->nullable();
			$table->string('value')->nullable();
			$table->boolean('publication')->default(1)->unsigned()->nullable();
			
			$table->foreign('product_attribute_group_id')->references('id')->on('products_attributes_group')->onDelete('cascade');
		});
	}

	public function down(){
		Schema::drop('products_attributes');
	}

}
