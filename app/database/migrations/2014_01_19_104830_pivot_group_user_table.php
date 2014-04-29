<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotGroupUserTable extends Migration {

	public function up(){
		Schema::create('group_user', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('group_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	public function down(){
		Schema::drop('group_user');
	}

}
