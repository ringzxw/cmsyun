<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_imports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->tinyInteger('type')->index()->comment('导入类型')->nullable();
            $table->integer('employee_id')->index()->comment('导入员工');
            $table->integer('project_item_id')->comment('主推产品');
            $table->tinyInteger('labels')->comment('导入等级')->nullable();
            $table->string('title')->comment('导入标题')->nullable();
            $table->string('file')->comment('文件路径')->nullable();
            $table->integer('success')->comment('本次导入')->nullable()->default(0);
            $table->string('import_status')->comment('导入状态')->nullable();
            $table->tinyInteger('status')->index()->comment('上传状态')->nullable();
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
        Schema::dropIfExists('mobile_imports');
    }
}
