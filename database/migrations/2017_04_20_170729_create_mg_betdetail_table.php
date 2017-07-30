<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMgBetdetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mg_betdetail', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			$table->integer('id', true);
			$table->bigInteger('rowid')->unique('rowid');
			$table->string('accountnumber', 100);
			$table->string('displayname', 100);
			$table->string('displaygamecategory', 100);
			$table->integer('sessionid');
			$table->dateTime('gameendtime');
			$table->decimal('totalwager', 16);
			$table->decimal('totalpayout', 16);
			$table->integer('progressivewager');
			$table->string('isocode', 10);
			$table->string('gameplatform', 50);
			$table->integer('moduleid');
			$table->integer('clientid');
			$table->integer('transactionid');
			$table->integer('pca');
			$table->dateTime('addtime');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mg_betdetail');
	}

}
