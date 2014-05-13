<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	public function up(){
		
		Schema::create('pages', function(Blueprint $table) {
			$table->increments('id');
			$table->boolean('in_menu')->default(0)->unsigned()->nullable();
			$table->integer('sort_menu')->default(0)->unsigned()->nullable();
			$table->string('template',100)->nullable();
			$table->string('language',10)->nullable();
			$table->string('name',100)->nullable();
			$table->string('seo_url',255)->nullable();
			$table->string('seo_title',255)->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->string('seo_h1')->nullable();
			$table->mediumText('content')->nullable();
			$table->boolean('publication')->default(1)->unsigned()->nullable();
			$table->boolean('start_page')->default(0)->unsigned()->nullable();
			$table->timestamps();
		});
	}
	public function down(){
		
		Schema::drop('pages');
	}

}