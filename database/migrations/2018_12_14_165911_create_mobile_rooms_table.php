<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile', 20)->index()->comment('联系方式')->nullable();
            $table->string('buy_room', 100)->comment('购买小区')->nullable();
            $table->string('buy_price', 100)->comment('购买价格')->nullable();
            $table->timestamp('buy_time')->comment('购买时间')->nullable();
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
        Schema::dropIfExists('mobile_rooms');
    }
}
