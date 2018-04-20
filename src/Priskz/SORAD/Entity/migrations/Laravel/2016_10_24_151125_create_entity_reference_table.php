<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityReferenceTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entity_reference', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('entity_uuid', 191)->nullable();
			$table->string('entity_type', 191)->nullable();
			$table->integer('entity_id')->nullable();
			$table->string('reference_uuid', 191)->nullable();
			$table->string('reference_type', 191)->nullable();
			$table->integer('reference_id')->nullable();
			$table->integer('order')->nullable();
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
		Schema::drop('entity_reference');
	}
}