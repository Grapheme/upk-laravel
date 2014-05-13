<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotGroupRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_role', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('group_id')->unsigned()->index();
			$table->integer('role_id')->unsigned()->index();
			$table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_role');
	}

}
