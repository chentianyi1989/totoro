<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgbetdetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agbetdetail', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			$table->integer('id', true);
			$table->string('billNo', 20)->unique('billNo')->comment('注单流水号');
			$table->string('playerName', 20)->index('playerName')->comment('玩家账号');
			$table->string('agentCode', 20)->nullable()->comment('代理商编号');
			$table->string('gameCode', 20)->nullable()->comment('游戏局号');
			$table->float('netAmount', 9)->nullable()->default(0.00)->comment('玩家输赢额度');
			$table->dateTime('betTime')->nullable()->index('betTime')->comment('投注时间');
			$table->string('gameType', 10)->nullable()->comment('游戏类型');
			$table->float('betAmount', 9)->nullable()->default(0.00)->comment('投注金额');
			$table->float('validBetAmount', 9)->nullable()->default(0.00)->comment('有效投注额度');
			$table->integer('flag')->nullable()->default(0)->comment('结算状态');
			$table->integer('playType')->nullable()->default(0)->comment('游戏玩法');
			$table->string('currency', 10)->nullable()->comment('货币类型');
			$table->string('tableCode', 10)->nullable()->comment('桌子编号');
			$table->string('loginIP', 20)->nullable()->comment('玩家IP');
			$table->dateTime('recalcuTime')->nullable()->comment('注单重新派彩时间');
			$table->string('platformId', 10)->nullable()->comment('平台编号');
			$table->string('platformType', 10)->nullable()->comment('平台类型');
			$table->string('stringex', 100)->nullable()->comment('产品附注(通常为空)');
			$table->string('remark', 100)->nullable()->comment('轮盘游戏 -  额外资讯');
			$table->string('round', 10)->nullable();
			$table->integer('copyFlag')->nullable()->default(0)->index('copyFlag')->comment('更新标志');
			$table->string('filePath', 40)->nullable()->comment('文件路径');
			$table->string('prefix', 10)->nullable()->index('prefix')->comment('站点前缀');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agbetdetail');
	}

}
