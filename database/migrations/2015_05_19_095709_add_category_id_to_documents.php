<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdToDocuments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('documents', function(Blueprint $table)
		{
			Schema::table('documents', function(Blueprint $table)
			{
				$table->integer('category_id')->unsigned();
				$table->foreign('category_id')
					->references('id')
					->on('categories')
					->onUpdate('cascade');

			});
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('documents', function(Blueprint $table)
		{
			$table->dropForeign("documents_category_id_foreign");
			$table->dropColumn('category_id');
		});
	}

}
