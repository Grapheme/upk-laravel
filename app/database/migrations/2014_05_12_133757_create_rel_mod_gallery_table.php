<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelModGalleryTable extends Migration {

	public function up(){
        if (!Schema::hasTable('rel_mod_gallery')) {
    		Schema::create('rel_mod_gallery', function(Blueprint $table) {
    			$table->increments('id');
                $table->string('module', 16)->nullable();
                $table->integer('unit_id')->default(0)->unsigned()->nullable();
                $table->integer('gallery_id')->default(0)->unsigned()->nullable();
           		$table->index('module');
           		$table->index('module', 'unit_id', 'gallery_id');
           		//$table->index('gallery_id');
    		});
        }
	}

	public function down(){
		Schema::dropIfExists('rel_mod_gallery');
	}

}