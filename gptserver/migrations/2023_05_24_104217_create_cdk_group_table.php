<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use App\Model\CdkGroup;

class CreateCdkGroupTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cdk_group', function (Blueprint $table) {
            $table->comment('兑换码批次表');
            $table->bigIncrements('id')->comment('兑换码批次号');
            $table->string('name', 50)->comment('服务对象名称');
            $table->unsignedSmallInteger('num')->default(0)->comment('生成数量');
            $table->unsignedBigInteger('package_id')->default(0)->comment('套餐ID');
            $table->string('remark', 300)->nullable()->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cdk_group');
    }
}
