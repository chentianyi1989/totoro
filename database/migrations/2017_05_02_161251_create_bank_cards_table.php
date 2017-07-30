<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_cards', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->COMMENT = '银行卡';
            $table->increments('id');

            $table->string('card_no', 150)->comment('卡号');
            $table->tinyInteger('card_type')->default(1)->comment('卡类型 储蓄卡');
            $table->integer('bank_id')->comment('银行ID');
            $table->string('phone', 50)->nullable()->comment('办卡预留手机号');
            $table->string('username', 150)->comment('持卡人姓名');
            $table->string('bank_address')->nullable()->comment('持卡人姓名');

            $table->tinyInteger('on_line')->default(1)->comment('0上线1下线');

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
