<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name',100)->unique();
            $table->string('real_name', 50);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('qq')->nullable();
            $table->string('password');
            $table->string('original_password')->comment('原始密码');
            $table->tinyInteger('gender')->default(0)->comment('0男1女');
            $table->tinyInteger('is_daili')->default(0)->comment('1为代理');
            $table->integer('top_id')->default(0)->comment('上级 id');
            $table->string('invite_code', 100)->unique()->comment('邀请注册码');

            $table->string('qk_pwd', 100)->nullable()->comment('取款密码');

            $table->decimal('money',16,2)->default(0)->comment('中心账户余额');
            $table->decimal('fs_money',16,2)->default(0)->comment('反水账户余额');
            $table->decimal('total_amount',16,2)->default(0)->comment('平台总投注额');
            $table->integer('score')->default(0)->comment('积分');

            $table->string('register_ip')->nullable()->comment('注册IP');
            $table->string('last_login_ip')->nullable()->comment('最后登录ip');
            $table->timestamp('last_login_at')->nullable()->comment('最后登录时间');

            $table->string('bank_username')->nullable()->comment('开户人名字');
            $table->string('bank_name')->nullable()->comment('银行名称');
            $table->string('bank_branch_name')->nullable()->comment('开户行网点');
            $table->string('bank_card')->nullable()->comment('银行卡号');
            $table->string('bank_address')->nullable()->comment('开户地址');

            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->tinyInteger('is_login')->default(0)->comment('0 未登录 1已登录');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        //用户登录日志
        Schema::create('member_login_log', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('member_id')->nullable();
            $table->string('ip', 20)->nullable()->comment('登录ip');
            $table->tinyInteger('is_login')->default(0)->comment('0登录 1登出');

            $table->timestamps();
        });

        //代理申请表
        Schema::create('member_daili_apply', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('member_id')->nullable();
            $table->string('name', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 20)->nullable();
            $table->string('msn_qq', 32)->nullable();
            $table->text('about')->nullable();
            $table->tinyInteger('status')->default(0)->comment('申请状态');
            $table->text('fail_reason')->nullable();

            $table->timestamps();
        });

        //代理佣金发放记录
        Schema::create('daili_money_log', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('member_id');
            $table->decimal('yl_money', 16)->default(0.00)->comment('盈利情况');
            $table->decimal('money', 16)->default(0.00)->comment('佣金');
            $table->string('remark')->nullable();
            $table->string('last_month', 10)->default(1);

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
