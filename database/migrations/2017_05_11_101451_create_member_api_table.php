<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_api', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->comment = '会员-api';
            $table->increments('id');

            $table->integer('member_id')->comment('');
            $table->integer('api_id')->comment('');
            $table->string('username', 100)->comment('平台账号');
            $table->string('password', 150)->comment('平台密码');
            $table->decimal('money', 16,2)->default(0)->comment('平台余额');

            $table->string('description')->nullable()->comment('描述');
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
