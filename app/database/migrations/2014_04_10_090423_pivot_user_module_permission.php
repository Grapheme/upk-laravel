<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotUserModulePermission extends Migration {

	public function up(){
		Schema::create('module_permissions', function(Blueprint $table){
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->integer('module_id')->unsigned()->nullable()->index();
			$table->integer('permission_id')->unsigned()->nullable()->index();
			$table->boolean('value')->unsigned()->default(1);
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
			$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
		});
	}

	public function down(){
		Schema::drop('module_permissions');
	}

}
