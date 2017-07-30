<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('member_id')->comment('');
            $table->tinyInteger('type')->default(1)->comment('反馈类型');

            $table->text('content')->nullable()->comment('内容');

            $table->string('phone')->nullable()->comment('手机');

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
        Schema::dropIfExists('feedback');
    }
}
