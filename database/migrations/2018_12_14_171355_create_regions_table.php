<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->index()->comment('地区名称')->nullable();
            $table->integer('level')->index()->comment('等级')->nullable();
            $table->integer('parent_id')->index()->comment('父ID')->nullable();
            $table->string('pinyin',100)->comment('拼音')->nullable();
            $table->string('area_code',100)->comment('区域代码')->nullable();
            $table->string('zip_code',100)->comment('邮编')->nullable();
            $table->string('merger_name',190)->comment('组合名称')->nullable();
            $table->string('city_code',100)->comment('区号')->nullable();
            $table->string('short_name',100)->comment('简称')->nullable();
            $table->string('lng',100)->comment('X坐标')->nullable();
            $table->string('lat',100)->comment('Y坐标')->nullable();
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
        Schema::dropIfExists('regions');
    }
}
