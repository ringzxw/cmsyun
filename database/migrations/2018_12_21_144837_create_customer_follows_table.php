<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_follows', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('customer_id')->index()->comment('所属客户');
            $table->integer('creator_id')->index()->comment('创建者ID');
            $table->tinyInteger('type')->comment('类型')->nullable();
            $table->tinyInteger('before_status')->comment('操作前状态')->nullable();
            $table->tinyInteger('after_status')->comment('操作后状态')->nullable();
            $table->tinyInteger('before_label')->comment('操作前意向')->nullable();
            $table->tinyInteger('after_label')->comment('操作后意向')->nullable();
            $table->text('content')->comment('内容')->nullable();
            $table->timestamp('biz_time')->comment('业务时间')->nullable();
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
        Schema::dropIfExists('customer_follows');
    }
}
