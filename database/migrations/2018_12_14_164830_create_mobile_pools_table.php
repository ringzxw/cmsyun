<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobilePoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_pools', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('mobile_import_id')->index()->comment('导入批次')->nullable();
            $table->string('mobile', 20)->index()->comment('联系方式')->nullable();
            $table->string('name', 50)->comment('客户姓名')->nullable();
            $table->integer('creator_id')->index()->comment('创建人')->nullable();
            $table->tinyInteger('status')->index()->comment('状态')->nullable();
            $table->integer('user_id')->index()->comment('使用人')->nullable();
            $table->timestamp('user_at')->index()->comment('使用时间')->nullable();
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
        Schema::dropIfExists('mobile_pools');
    }
}
