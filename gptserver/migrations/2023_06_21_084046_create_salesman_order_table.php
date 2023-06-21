<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSalesmanOrderTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salesman_order', function (Blueprint $table) {
            $table->comment('分销订单表');
            $table->bigIncrements('id');
            $table->tinyInteger('type')->comment('类型');
            $table->bigInteger('order_id')->comment('订单ID');
            $table->string('ratio')->comment('比例');
            $table->decimal('price',9)->comment('佣金');
            $table->bigInteger('user_id')->default(0)->comment('分销员ID');
            $table->bigInteger('custom_id')->default(0)->comment('客户ID');
            $table->tinyInteger('status')->default(\App\Model\SalesmanOrder::STATUS_PADDING)->comment('状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salesman_order');
    }
}
