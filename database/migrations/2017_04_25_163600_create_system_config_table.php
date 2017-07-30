<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //系统网站配置
        Schema::create('system_config', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('site_logo')->nullable()->comment('网站logo');
            $table->string('m_site_logo')->nullable()->comment('手机站网站logo');
            $table->string('site_name', 150)->nullable()->comment('网站名称');
            $table->string('site_title', 150)->nullable()->comment('网站标题');
            $table->string('keyword')->nullable()->comment('关键字');
            $table->string('phone1', 50)->nullable()->comment('客户电话1');
            $table->string('phone2', 50)->nullable()->comment('客户电话2');
            $table->string('site_domain')->nullable()->comment('网站主域名');
            //
            $table->tinyInteger('is_maintain')->default(0)->comment('0 正常1维护');
            $table->string('maintain_desc')->nullable()->comment('维护提示语');

            //活跃用户月充值金额
            $table->decimal('active_member_money')->default(0)->comment('活跃用户月充值金额');

            //支付宝账号
            $table->string('alipay_nickname')->nullable()->comment('支付宝昵称');
            $table->string('alipay_account')->nullable()->comment('支付宝账号');
            $table->string('alipay_qrcode')->nullable()->comment('支付宝 二维码图片');
            $table->tinyInteger('alipay_on_line')->default(0)->comment('0上线1下线');
            //微信支付
            $table->string('wechat_nickname')->nullable()->comment('微信昵称');
            $table->string('wechat_account')->nullable()->comment('微信账号');
            $table->string('wechat_qrcode')->nullable()->comment('微信 二维码图片');
            $table->tinyInteger('wechat_on_line')->default(0)->comment('0上线1下线');

            $table->string('web_domain')->nullable()->comment('网站域名');

            $table->timestamps();
        });

        //ip 限制
        Schema::create('black_list_ip', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('ip')->comment('IP 地址');
            $table->text('remark')->nullable()->comment('备注');

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
