<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('employee_id')->index()->comment('员工ID');
            $table->integer('biz_type')->index()->comment('业务类型');
            $table->integer('biz_action')->index()->comment('业务操作');
            $table->integer('biz_id')->index()->comment('业务ID');
            $table->string('title')->comment('消息标题')->nullable();
            $table->string('content')->comment('消息内容')->nullable();
            $table->integer('creator_id')->index()->comment('创建者ID,系统创建为null')->nullable();
            $table->tinyInteger('is_read')->comment('是否已读')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_messages');
    }
}
