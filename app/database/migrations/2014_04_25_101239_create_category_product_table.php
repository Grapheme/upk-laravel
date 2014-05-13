<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryProductTable extends Migration {

	public function up(){
		Schema::create('category_product', function(Blueprint $table){
			$table->increments('id');
			$table->integer('category_id')->unsigned()->index();
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
			$table->integer('product_id')->unsigned()->index();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
		});
	}

	public function down(){
		Schema::drop('category_product');
	}

}
