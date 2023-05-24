<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateChatGptModelRecordTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_gpt_model_record', function (Blueprint $table) {
            $table->comment('模型审核记录');
            $table->bigIncrements('id');
            $table->char('chat_gpt_model_id', 16)->comment('chat_gpt_model_id');
            $table->string('label')->comment('官方返回的禁用类型 Porn：色情，Abuse：谩骂，Ad：广告，Custom：自定义违规');
            $table->mediumtext('trigger')->comment('触发词');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_gpt_model_record');
    }
}
