<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateChatGptModelCountTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_gpt_model_count', function (Blueprint $table) {
            $table->char('chat_gpt_model_id', 16)->primary()->comment('模型 id');
            $table->unsignedInteger('likes')->default(0)->comment('点赞量');
            $table->unsignedBigInteger('uses')->default(0)->comment('使用量');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_gpt_model_count');
    }
}
