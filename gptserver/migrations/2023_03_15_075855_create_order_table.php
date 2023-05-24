<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {
            $table->comment('订单表');
            $table->bigIncrements('id');
            $table->string('trade_no')->comment('订单号');
            $table->string('paid_no')->nullable()->comment('第三方的支付流水号');
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->string('channel')->comment('支付渠道，微信，支付宝');
            $table->string('pay_type')->comment('支付类型, h5, native');
            $table->decimal('price', 9)->comment('支付金额');
            $table->decimal('payment', 9)->default(0)->comment('实际支付金额');
            $table->json('payload')->comment('支付参数');
            $table->tinyInteger('status')->default(\App\Model\Order::STATUS_UNPAID)->comment('支付状态');
            $table->unsignedBigInteger('package_id')->comment('购买的套餐');
            $table->string('package_name')->nullable()->comment('套餐名称');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
}
