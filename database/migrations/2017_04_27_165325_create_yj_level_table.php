<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYjLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yj_level', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->tinyInteger('level')->default(1)->comment('等级');
            $table->string('name', 50)->nullable()->comment('等级名称');
            $table->integer('num')->default(0)->comment('活跃人数');
            $table->decimal('min')->default(0)->comment('最小金额');
            $table->decimal('max')->nullable()->comment('最大金额');
            $table->string('rate', 10)->default(0)->comment('佣金比例');

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
