<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AddPlatformSourceColumnToOrderTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order', function (Blueprint $table) {
            $table->tinyInteger('platform')->default(\App\Model\Order::PLATFORM_GPT)->comment('来源平台, gpt-link或aiyaaa');
            $table->unsignedBigInteger('business_id')->default(0)->comment('GPTlink的商户ID/yaiaa的模型ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
            //
        });
    }
}
