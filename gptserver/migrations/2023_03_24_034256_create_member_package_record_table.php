<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateMemberPackageRecordTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('member_package_record', function (Blueprint $table) {
            $table->comment('用户套餐记录');
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->unsignedBigInteger('package_id')->comment('套餐ID');
            $table->tinyInteger('identity')->default(\App\Model\Package::IDENTITY_USER)->comment('套餐身份');
            $table->string('package_name')->comment('套餐名称');
            $table->string('code')->nullable()->comment('用户标识');
            $table->unsignedSmallInteger('expired_day')->comment('有效期');
            $table->bigInteger('num')->comment('数量');
            $table->tinyInteger('channel')->comment('套餐渠道, 系统赠送，订单购买，后台操作');
            $table->tinyInteger('type')->comment('类型，与套餐的类型保持一致');
            $table->timestamp('created_at')->useCurrent()->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_package_record');
    }
}
