<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateWithdrawTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('withdraw', function (Blueprint $table) {
            $table->comment('提现记录表');
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('用户ID');
            $table->string('serial_no', 40)->comment('流水号');
            $table->decimal('price')->comment('提现金额');
            $table->string('channel')->comment('提现渠道');
            $table->json('config')->comment('提现配置');
            $table->tinyInteger('status')->comment('状态');
            $table->string('paid_no', 150)->nullable()->comment('付款流水号');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw');
    }
}
