<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile', 20)->index()->comment('联系方式')->nullable();
            $table->string('address', 100)->comment('联系地址')->nullable();
            $table->string('identity', 32)->comment('身份证号')->nullable();
            $table->string('car', 50)->comment('汽车型号')->nullable();
            $table->string('car_num', 20)->comment('车牌号')->nullable();
            $table->string('shop', 50)->comment('店铺名称')->nullable();
            $table->string('shop_address', 50)->comment('店铺地址')->nullable();
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
        Schema::dropIfExists('mobile_details');
    }
}
