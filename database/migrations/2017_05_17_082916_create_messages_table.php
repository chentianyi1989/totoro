<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 50)->nullable()->comment('标题 系统公告 活动公告');
            $table->string('content')->nullable()->comment('公告内容');
            $table->string('url')->nullable()->comment('跳转链接');

            $table->timestamps();
        });

        Schema::create('member_message', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->comment = '会员-message';
            $table->increments('id');

            $table->integer('member_id')->comment('');
            $table->integer('message_id')->comment('');

            $table->tinyInteger('is_read')->default(0)->comment('0未读1已读');

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
        Schema::dropIfExists('messages');
    }
}
