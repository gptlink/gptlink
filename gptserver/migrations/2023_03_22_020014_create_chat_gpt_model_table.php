<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateChatGptModelTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_gpt_model', function (Blueprint $table) {
            $table->comment('智能模型');
            $table->char('id', 16)->primary()->comment('字符 id');
            $table->unsignedBigInteger('user_id')->default(0)->comment('用户 id');
            $table->string('icon')->comment('模型图片');
            $table->string('name', 50)->comment('模型名称');
            $table->string('prompt')->comment('开场提示语');
            $table->text('system')->comment('咒语');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态:1.启动;2.关闭;3.待审核;4.违规');
            $table->unsignedTinyInteger('sort')->default(0)->comment('排序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_gpt_model');
    }
}
