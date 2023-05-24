<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task', function (Blueprint $table) {
            $table->comment('任务');
            $table->bigIncrements('id');
            $table->string('type', 50)->comment('任务类型');
            $table->string('title', 50)->nullable()->comment('标题');
            $table->string('desc', 100)->nullable()->comment('描述');
            $table->string('platform')->default(1)->comment('服务应用');
            $table->string('share_image')->nullable()->comment('背景图');
            $table->unsignedTinyInteger('status')->default(2)->comment('状态:1 开启;2 关闭');
            $table->json('rule')->comment('规则');
            $table->unsignedBigInteger('package_id')->comment('赠送套餐 id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
}
