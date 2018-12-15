<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile', 20)->index()->comment('联系方式')->nullable();
            $table->string('company', 100)->comment('公司名称')->nullable();
            $table->string('registered', 100)->comment('注册资本')->nullable();
            $table->timestamp('registered_time')->comment('注册时间')->nullable();
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
        Schema::dropIfExists('mobile_companies');
    }
}
