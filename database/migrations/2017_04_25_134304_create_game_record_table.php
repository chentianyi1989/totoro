<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //游戏记录
        Schema::create('game_record', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('rowid', 100)->nullable()->comment('');
            $table->string('billNo', 100)->unique('billNo')->comment('注单流水号');
            $table->tinyInteger('api_type')->default(1)->comment('接口平台 如 AG MG');
            $table->string('playerName', 50)->index()->comment('玩家各平台账号');
            $table->string('name', 50)->nullabe()->comment('玩家账号');
            $table->integer('member_id')->nullabe()->comment('用户 ID');
            $table->string('agentCode', 20)->nullable()->comment('代理商编号');
            $table->string('gameCode', 20)->nullable()->comment('游戏局号');


            $table->decimal('netAmount', 16, 2)->default(0.00)->comment('玩家输赢额度');
            $table->timestamp('betTime')->nullable()->index()->comment('投注时间');

            $table->string('gameType', 10)->nullable()->comment('游戏类型');
            $table->decimal('betAmount', 16, 2)->nullable()->default(0.00)->comment('投注金额');
            $table->decimal('validBetAmount', 16 ,2)->nullable()->default(0.00)->comment('有效投注额度');
            $table->integer('flag')->nullable()->default(0)->comment('结算状态');
            $table->integer('playType')->nullable()->default(0)->comment('游戏玩法');
            $table->string('currency', 10)->nullable()->comment('货币类型');
            $table->string('tableCode', 10)->nullable()->comment('桌子编号');
            $table->string('loginIP', 20)->nullable()->comment('玩家IP');
            $table->timestamp('recalcuTime')->nullable()->comment('注单重新派彩时间');
            $table->string('platformId', 10)->nullable()->comment('平台编号');
            $table->string('platformType', 10)->nullable()->comment('平台类型');
            $table->string('stringex', 100)->nullable()->comment('产品附注(通常为空)');
            $table->string('remark', 100)->nullable()->comment('轮盘游戏 -  额外资讯');
            $table->string('round', 10)->nullable();
            $table->integer('copyFlag')->nullable()->default(0)->index('copyFlag')->comment('更新标志');
            $table->string('filePath', 40)->nullable()->comment('文件路径');

            $table->string('prefix', 10)->nullable()->index('prefix')->comment('站点前缀');

            $table->timestamps();
        });

        Schema::create('game_records', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('member_id')->nullable()->comment('对应的 member表id');
            $table->string('username')->nullable()->comment('游戏账号的登录名');
            $table->decimal('betAmount', 16, 2)->default(0)->comment('投注金额');
            $table->decimal('validBetAmount', 16, 2)->default(0)->comment('有效投注金额');
            $table->decimal('winAmount', 16, 2)->default(0)->comment('赢金额');
            $table->decimal('netPnl', 16, 2)->default(0)->comment('净输赢');
            $table->string('currency', 50)->nullable()->comment('币别');
            $table->timestamp('transactionTime')->nullable()->comment('交易时间');
            $table->string('gameCode', 100)->nullable()->comment('游戏代码');
            $table->string('betOrderNo')->nullable()->comment('投注订单编号');
            $table->timestamp('betTime')->nullable()->comment('投注时间');
            $table->integer('productType')->nullable()->comment('产品类别');
            $table->string('gameCategory', 150)->nullable()->comment('游戏类别');
            $table->string('sessionId', 150)->index()->nullable()->comment('会话标识');
            $table->text('additionalDetails')->nullable()->comment('额外细节');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
