<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsAttributesGroupTable extends Migration {

	public function up(){
		Schema::create('products_attributes_group', function(Blueprint $table){
			$table->increments('id');
			$table->string('title',100)->nullable();
			$table->boolean('publication')->default(1)->unsigned()->nullable();
		});
	}

	public function down(){
		Schema::drop('products_attributes_group');
	}

}
