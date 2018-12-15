<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('creator_id')->index()->comment('创建者');
            $table->integer('employee_id')->index()->comment('所属员工')->nullable();
            $table->integer('scene_id')->index()->comment('所属案场')->nullable();
            $table->string('name')->comment('姓名')->nullable();
            $table->string('mobile')->index()->comment('手机号');
            $table->tinyInteger('channel')->index()->comment('来源')->nullable();
            $table->tinyInteger('labels')->index()->comment('意向')->nullable();
            $table->tinyInteger('status')->index()->comment('状态')->nullable();
            $table->tinyInteger('age')->index()->comment('年龄')->nullable();
            $table->tinyInteger('gender')->index()->comment('性别')->nullable();
            $table->string('wechat', 50)->index()->comment('微信')->nullable();
            $table->string('wechat_nickname', 50)->index()->comment('微信昵称')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('latest_log_time')->index()->comment('跟进时间')->nullable();
            $table->timestamp('expect_come_time')->index()->comment('预计来访时间')->nullable();
            $table->timestamp('latest_come_time')->index()->comment('最新来访时间')->nullable();
            $table->timestamp('latest_success_time')->index()->comment('最新成交时间')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
