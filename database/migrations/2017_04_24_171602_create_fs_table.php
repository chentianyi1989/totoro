<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //返水记录
        Schema::create('fs_log', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('member_id')->comment('用户ID');
            $table->decimal('bet_money', 12)->default(0.00)->comment('下注金额');
            $table->decimal('yx_money', 12)->default(0.00)->comment('有效投注');
            $table->decimal('yingli', 12)->default(0.00)->comment('网站盈利');
            $table->tinyInteger('fs_level')->comment('返水等级');
            $table->decimal('fs_rate', 10)->default(0.00)->comment('返水比率%');
            $table->decimal('fs_money', 12)->default(0.00)->comment('返水金额');
            $table->string('fs_order', 20)->nullable()->comment('返水批次号');

            $table->timestamps();
        });

        //返水等级
        Schema::create('fs_level', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->tinyInteger('level')->default(0)->comment('等级');
            $table->string('name')->comment('等级名称');
            $table->decimal('quota', 16, 2)->default(0)->comment('额度');
            $table->string('rate', 10)->default(0)->comment('返水比例');

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
