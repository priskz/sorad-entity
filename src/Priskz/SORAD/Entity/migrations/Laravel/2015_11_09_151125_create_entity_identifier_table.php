<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityIdentifierTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entity_identifier', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('entity_type', 191)->nullable();
			$table->integer('entity_id')->nullable();
			$table->string('uuid', 191)->unique()->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('entity_identifier');
	}
}