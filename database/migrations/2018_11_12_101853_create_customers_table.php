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
            $table->integer('create_user_id')->index()->comment('创建者');
            $table->string('name')->comment('姓名');
            $table->string('mobile')->index()->comment('手机号');
            $table->tinyInteger('labels')->index()->comment('意向')->nullable();
            $table->tinyInteger('status')->index()->comment('状态')->nullable();
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
