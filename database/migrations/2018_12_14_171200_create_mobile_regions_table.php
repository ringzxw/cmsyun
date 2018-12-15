<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_regions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('region_id')->index()->comment('区域ID')->nullable();
            $table->string('mobile', 20)->index()->comment('联系方式')->nullable();
            $table->tinyInteger('type')->comment('类型')->nullable();
            $table->string('prov', 20)->comment('省份')->nullable();
            $table->string('city', 20)->comment('城市')->nullable();
            $table->string('name', 20)->comment('运营商名称')->nullable();
            $table->string('area_code', 20)->comment('区号')->nullable();
            $table->string('num', 20)->comment('号段')->nullable();
            $table->string('post_code', 20)->comment('邮编')->nullable();
            $table->string('prov_code', 20)->comment('身份证号开头几位')->nullable();
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
        Schema::dropIfExists('mobile_regions');
    }
}
