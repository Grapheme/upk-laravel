<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateI18nPagesTable extends Migration {

	public function up(){
        if (!Schema::hasTable('i18n_pages')) {
    		Schema::create('i18n_pages', function(Blueprint $table) {
                $table->increments('id');
                $table->string('slug',64)->nullable();
                $table->string('template',100)->nullable();
                $table->boolean('publication')->default(1)->unsigned()->nullable();
    			$table->boolean('start_page')->default(0)->unsigned()->nullable();
                $table->boolean('in_menu')->default(0)->unsigned()->nullable(); ## don't use
                $table->integer('sort_menu')->default(0)->unsigned()->nullable(); ## don't use
    			$table->timestamps();
           		$table->index('publication');
     		});
        }

        if (!Schema::hasTable('i18n_pages_meta')) {
    		Schema::create('i18n_pages_meta', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('page_id')->default(0)->unsigned()->nullable();
                $table->string('language',10)->nullable();
                $table->string('name',100)->nullable();
    			$table->mediumText('content')->nullable();
                $table->string('seo_url',255)->nullable();
                $table->string('seo_title',255)->nullable();
                $table->text('seo_description')->nullable();
                $table->text('seo_keywords')->nullable();
                $table->string('seo_h1')->nullable();
    			$table->timestamps();
        		$table->index('page_id');
        		$table->index('language');
        		$table->index('seo_url');
    		});
        }
	}

	public function down(){
		Schema::dropIfExists('i18n_pages');
		Schema::dropIfExists('i18n_pages_meta');
	}

}