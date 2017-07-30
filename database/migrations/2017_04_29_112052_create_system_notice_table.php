<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_notice', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('title', 50)->nullable()->comment('标题 系统公告 活动公告');
            $table->string('content')->nullable()->comment('公告内容');
            $table->integer('sort')->default(0)->comment('排序');

            $table->string('url')->nullable()->commnet('跳转链接');

            $table->tinyInteger('on_line')->default(0)->comment('0上线 1下线');

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
