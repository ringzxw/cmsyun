<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('customer_id')->index()->comment('客户ID');
            $table->tinyInteger('house_old')->index()->comment('户籍')->nullable();
            $table->tinyInteger('house_region')->index()->comment('居住区域')->nullable();
            $table->tinyInteger('job')->index()->comment('工作类型')->nullable();
            $table->tinyInteger('job_time')->index()->comment('工作年限')->nullable();
            $table->tinyInteger('job_region')->index()->comment('工作区域')->nullable();
            $table->tinyInteger('buy_type')->index()->comment('购买用途')->nullable();
            $table->tinyInteger('liquidity')->index()->comment('流动资金')->nullable();
            $table->tinyInteger('decision')->index()->comment('决策权')->nullable();
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
        Schema::dropIfExists('customer_details');
    }
}
