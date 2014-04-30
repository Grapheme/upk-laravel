<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateI18nNewsTable extends Migration {

	public function up(){
		Schema::create('i18n_news', function(Blueprint $table) {
			$table->increments('id');
			$table->string('template',100)->nullable();
			$table->string('title',200)->nullable();
			$table->text('preview')->nullable();
			$table->text('content')->nullable();
			$table->string('seo_url',255)->nullable();
			$table->string('seo_title',255)->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->string('seo_h1')->nullable();
		});

		Schema::create('i18n_news_meta', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('news_id')->default(0)->unsigned()->nullable();
			$table->integer('news_ver_id')->default(0)->unsigned()->nullable();
			$table->string('language',10)->nullable();
			$table->boolean('publication')->default(1)->unsigned()->nullable();
			$table->integer('sort')->default(0)->unsigned()->nullable(); ## don't use
			$table->timestamps();
			$table->unique('news_id','news_ver_id');
    		$table->index('news_id');
    		$table->index('news_ver_id');
    		$table->index('language');
    		$table->index('publication');
		});
	}

	public function down(){
		Schema::drop('i18n_news');
		Schema::drop('i18n_news_meta');
	}

}