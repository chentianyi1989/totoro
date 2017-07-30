<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('admin_action_money_log', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('user_id')->comment('管理员ID');
            $table->integer('member_id')->comment('会员ID');

            $table->decimal('old_money', 12,2)->default(0.00)->comment('原余额');
            $table->decimal('new_money', 12,2)->default(0.00)->comment('修改后的余额');

            $table->decimal('old_fs_money', 12,2)->default(0.00)->comment('原返水余额');
            $table->decimal('new_fs_money', 12,2)->default(0.00)->comment('修改后的返水余额');

            $table->text('remark')->nullable()->comment('描述');

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
