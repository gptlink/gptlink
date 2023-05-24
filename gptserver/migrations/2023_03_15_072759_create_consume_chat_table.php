<?php

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateConsumeChatTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consume_chat', function (Blueprint $table) {
            $table->comment('chat消费记录');
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('用户ID');
            $table->string('prompt', 500)->comment('问题');
            $table->mediumInteger('prompt_tokens')->default(0)->comment('问题消耗的令牌数');
            $table->mediumInteger('completion_tokens')->default(0)->comment('返回消耗的令牌数');
            $table->mediumInteger('total_tokens')->default(0)->comment('合计消费的token数');
            $table->timestamp('created_at')->useCurrent()->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consume_chat');
    }
}
