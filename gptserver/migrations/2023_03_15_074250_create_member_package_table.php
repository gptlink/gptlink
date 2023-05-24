<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateMemberPackageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('member_package', function (Blueprint $table) {
            $table->comment('用户套餐');
            $table->bigIncrements('id');
            $table->string('name')->comment('展示名称，包的show_name');
            $table->string('code', 20)->nullable()->comment('套餐标识');
            $table->bigInteger('user_id')->comment('用户');
            $table->tinyInteger('status')->comment('状态');
            $table->tinyInteger('channel')->comment('套餐渠道, 系统赠送，订单购买，后台操作');
            $table->tinyInteger('type')->comment('类型，与套餐的类型保持一致');
            $table->bigInteger('num')->default(0)->comment('套餐量, -1表示不限制');
            $table->unsignedBigInteger('used')->default(0)->comment('用量');
            $table->tinyInteger('level')->default(0)->comment('扣费优先级，越大越前');
            $table->date('expired_at')->nullable()->comment('有效期');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_package');
    }
}
