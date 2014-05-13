<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateManufacturersTable extends Migration {

	public function up(){
		Schema::create('manufacturers', function(Blueprint $table){
			
			$table->increments('id');
			$table->integer('sort')->default(0)->unsigned()->nullable();
			$table->string('title',100)->nullable();
			$table->text('description')->nullable();
			$table->text('logo')->nullable();
			
			$table->string('seo_url',255)->nullable();
			$table->string('seo_title',255)->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->string('seo_h1')->nullable();
			$table->string('template',100)->nullable();
			$table->string('language',10)->nullable();
			$table->boolean('publication')->default(1)->unsigned()->nullable();
			$table->timestamps();
		});
	}
	public function down(){
		Schema::drop('manufacturers');
	}

}
